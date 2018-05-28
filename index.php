<?php session_start();
require_once("function.php");
$obj=new ConnDB();
$admin_user=$_SESSION["admin_user"];
$wid=$_SESSION["wid"];
$obj->connMS();
$numpatient = $obj->msAll("select count(*) as allpatient from Ipd_h i  where ward_id = '$wid'  and discharge_status='0'");//เลือกข้อมูล

?>
<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="materialize/js/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="materialize/js/materialize.js"></script>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>
      <link href="dist/css/select2.min.css" rel="stylesheet" />
      <script src="dist/js/select2.min.js"></script>
      <script src="ajax.js"></script>

      <style type="text/css">
        @font-face {
          font-family: "kanit";
          src: url("materialize/fonts/roboto/Kanit-Regular.ttf");
        }
        body{
        font-family: "kanit";
        }

		footer.page-footer {
		  margin: 0;
		}

        </style>
        <title>เบิกอาหารออนไลน์</title>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
	<img src="H:/DCIM/IMG_0321.JPG" width="960" height="1280" alt="" />
	<?php
	$Root_Path =  $_SERVER['DOCUMENT_ROOT']."/Website";
	echo $Root_Path;
	?>
    <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper blue darken-1">
        <a href="index.php" class="brand-logo">&nbsp;เบิกอาหารออนไลน์</a>
        <ul class="right hide-on-med-and-down">
        <?php if(isset($wid)&&isset($admin_user)){?>
		  <li><a href="index.php?files=foodorder">เบิกอาหาร</a></li>
          <li><a href="#">จำนวนผู้ป่วย <?php echo $numpatient->allpatient;?> ราย</a></li>
          <li><a href="foodprint.php" target="_BLANK">รายงาน</a></li>
          <li><a href="#"><?php $rowward=$obj->msQuery("Ward"," where ward_id='$wid' ");echo $rowward->ward_name;?></a></li>
          <li><a href="badges.html"><?php echo $admin_user;?></a></li>
          <!-- Dropdown Trigger -->
          <li><a href="logout.php">ออกจากระบบ</a></li>
        <?php }else if(isset($admin_user)){?>
          <li><a href="index.php?files=foodview">รายงานอาหารตามหอผู้ป่วย</a></li>
          <li><a href="index.php?files=report">รายงานสรุปยอดอาหาร</a></li>
          <li><a href="index.php?files=card">พิมพ์สติกเกอร์</a></li>
          <li><a href="index.php?files=cardbd">พิมพ์สติกเกอร์ BD</a></li>
          <li><a href="#!"><?php echo $admin_user;?></a></li>
          <li><a href="logout.php">ออกจากระบบ</a></li>
        <?php }else{?>
		  <li><a href="http://intra.sunpasit.go.th/portal/index.php">อินทราเน็ต</a></li>
          <li><a href="index.php?files=flogin">สำหรับงานโภชนาการ</a></li>
		  <li><a href="manual.pdf" target="_BLANK">คู่มือการใช้งาน</a></li>
        <?php }?>
        </ul>
      </div>
    </nav>
</div>

<?php if(empty($files)){?>
  <?php include("login.php");?>
<?php }else{?>
  <?php include($files.".php");?>
<?php }?>



      
    </body>
  </html>