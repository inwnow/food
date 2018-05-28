<?php session_start(); extract($_POST);extract($_GET);extract($_REQUEST);//extract($_SESSION);
/*function session_register($name){
    global $$name;
    $_SESSION[$name] = $$name;
    $$name = &$_SESSION[$name]; 
}	*/			
class ConnDB {
    private $conn;
    private $dbhost = "192.168.20.11";
    private $dbuser = "tops";
    private $dbpass = "rmsql";
	private $dbname = "food_db";
	

    private $mshost = "192.168.28.3";
    private $msuser = "homc";
    private $mspass = "homc";
	private $msname = "HOMC";
	
	 private $dbhost2 = "192.168.20.190";
	private $dbname2 = "p4psps";
		
    function construct(){

        $this->conn = new mysqli( $this->dbhost, $this->dbuser, $this->dbpass, $this->dbname );
			
        if( mysqli_connect_errno() )
        {
            die('Cannot connect to Database! : '. mysqli_connect_errno());
        }
			
        $this->conn->set_charset("utf8");		
	}

	 function conp4p(){

        $this->conn = new mysqli( $this->dbhost2, $this->dbuser, $this->dbpass, $this->dbname2 );
			
        if( mysqli_connect_errno() )
        {
            die('Cannot connect to Database! : '. mysqli_connect_errno());
        }
			
        $this->conn->set_charset("utf8");		
	}
	
	
	

	function numrows($table,$condition){
	$row=$this->conn->query("select * from $table $condition");
	$num=$row->num_rows;
	return $num;
    }

	function getQuery($table,$condition){
	$row=$this->conn->query("select * from $table $condition");
	$fetch=$row->fetch_object();
	return $fetch;
    }

	function getAll($condition){
	$row=$this->conn->query("$condition");
	$fetch=$row->fetch_object();
	return $fetch;
    }

	function getUpdate($table,$value,$condition){
	$row=$this->conn->query("update $table set $value $condition");
    }

	function getInsert($table,$value){
	$row=$this->conn->query("insert into $table values ($value)");
	return $row;
	}

	function getInsertfield($table,$field,$value){
	$row=$this->conn->query("insert into $table ($field)  values ($value)");
	return $row;
	}

	function getDelete($table,$condition){
	$row=$this->conn->query("delete from $table $condition");
	}

	function getFetch($condition){
	$row=$this->conn->query("$condition");
	return $row;
	}

	function connMS(){
		$serverName = "192.168.28.3"; //serverName ชื่อ Server
		$connectionInfo = array( "Database"=>"HOMC", "UID"=>"homc", "PWD"=>"homc","MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
		$this->conn = sqlsrv_connect( $serverName, $connectionInfo);
	}



	function msQuery($table,$condition){
			$this->connMS();
			$row = sqlsrv_query($this->conn,"SELECT * FROM $table $condition");
			$fetch=sqlsrv_fetch_object($row);
			return $fetch;
	}

	function msAll($condition){
			$this->connMS();
			$row=sqlsrv_query($this->conn,"$condition");
			$fetch=sqlsrv_fetch_object($row);
			return $fetch;
	}


	function msNum($table,$condition){
			$this->connMS();
			$row = sqlsrv_query($this->conn,"SELECT * FROM $table $condition");
			$num=sqlsrv_num_rows($row);
			return $num;
	}

	function msnumAll($condition){
		$this->connMS();
		$row=sqlsrv_query($this->conn,"$condition");
		$num=sqlsrv_num_rows($row);
		return $num;
}

	function msFetch($condition){
		$row = sqlsrv_query($this->conn,"$condition");
		return $row;
		}
	
	function session($var,$value){
		$_SESSION[$var]=$value;
	}
			
	function unset_session($var){
		$_SESSION[$var]=null;
	}
				
			function destroy_session(){
			session_destroy();
			}


	function upLoad($folder,$pic,$image1,$ext){
			if(!empty($pic)){
			$dated = time();
			$image = $folder."/".md5($dated).$ext;
			copy($pic, $image);
			}else{$image=$image1;}
			return $image;
		}	

	function getmain($url){
			echo "<script language='javascript'>location.replace('$url')</script>";
	}

	function a($url){
		return "location='index.php?files=$url'";
	}

	function chkAccess($sessname){
		if($_SESSION['admin_user'] != $sessname){
			session_unset();
			session_destroy();
			header("location:index.php");
			exit();
		}else{
		
		}
	}

	function getIP(){

						
						$IP = $_SERVER["REMOTE_ADDR"];
						return $IP;
		}

		function getdatetime(){

						$datetime=date("Y-m-d H:i:s");
						return $datetime;
		}

		function getday(){

						$datetime=date("Y-m-d");
						return $datetime;
		}

		function showdate($data){
		if(!empty($data) && $data!='0000-00-00 00:00:00' && $data!="0000-00-00"){
		$day=$data;
		$dd=substr($day,8,2);
		$mm=substr($day,5,2);
		$yy=substr($day,0,4);		
		if($mm=="01"){$m="มกราคม";}
		if($mm=="02"){$m="กุมภาพันธ์";}
		if($mm=="03"){$m="มีนาคม";}
		if($mm=="03"){$m="มีนาคม";}
		if($mm=="04"){$m="เมษายน";}
		if($mm=="05"){$m="พฤษภาคม";}
		if($mm=="06"){$m="มิถุนายน";}
		if($mm=="07"){$m="กรกฎาคม";}
		if($mm=="08"){$m="สิงหาคม";}
		if($mm=="09"){$m="กันยายน";}
		if($mm=="10"){$m="ตุลาคม";}
		if($mm=="11"){$m="พฤศจิกายน";}
		if($mm=="12"){$m="ธันวาคม";}
		$y=$yy+543;
		$data = $dd." ".$m." ".$y;
		return $data;
		}else{
		echo "ไม่ระบุวันที่";
		}
		}

		 function shortdate($data){
		if(!empty($data) && $data!='0000-00-00 00:00:00' && $data!="0000-00-00"){
		$day=$data;
		$dd=substr($day,8,2);
		$mm=substr($day,5,2);
		$yy=substr($day,0,4);		
		if($mm=="01"){$m="ม.ค.";}
		if($mm=="02"){$m="ก.พ.";}
		if($mm=="03"){$m="มี.ค.";}
		if($mm=="04"){$m="เม.ย.";}
		if($mm=="05"){$m="พ.ค.";}
		if($mm=="06"){$m="มิ.ย.";}
		if($mm=="07"){$m="ก.ค.";}
		if($mm=="08"){$m="ส.ค.";}
		if($mm=="09"){$m="ก.ย.";}
		if($mm=="10"){$m="ต.ค.";}
		if($mm=="11"){$m="พ.ย.";}
		if($mm=="12"){$m="ธ.ค.";}
		$y=$yy+543;
		$data = $dd." ".$m." ".$y;
		return $data;
		}else{
		echo "ไม่ระบุวันที่";
		}
		}

		function shortdatetime($data){
		if(!empty($data) && $data!='0000-00-00 00:00:00' && $data!="0000-00-00"){
		$day=$data;
		$dd=substr($day,8,2);
		$mm=substr($day,5,2);
		$yy=substr($day,0,4);		
		if($mm=="01"){$m="ม.ค.";}
		if($mm=="02"){$m="ก.พ.";}
		if($mm=="03"){$m="มี.ค.";}
		if($mm=="04"){$m="เม.ย.";}
		if($mm=="05"){$m="พ.ค.";}
		if($mm=="06"){$m="มิ.ย.";}
		if($mm=="07"){$m="ก.ค.";}
		if($mm=="08"){$m="ส.ค.";}
		if($mm=="09"){$m="ก.ย.";}
		if($mm=="10"){$m="ต.ค.";}
		if($mm=="11"){$m="พ.ย.";}
		if($mm=="12"){$m="ธ.ค.";}
		$y=$yy+543;
		$time=substr($day,11,5);
		$data = $dd." ".$m." ".$y." ".$time." น. ";

		return $data;
		}else{
		echo "ไม่ระบุวันที่";
		}
		}


		function showdatetime($data){
			if(!empty($data) && $data!='0000-00-00 00:00:00' && $data!="0000-00-00"){
			$day=$data;
			$dd=substr($day,8,2);
			$mm=substr($day,5,2);
			$yy=substr($day,0,4);		
			if($mm=="01"){$m="มกราคม";}
			if($mm=="02"){$m="กุมภาพันธ์";}
			if($mm=="03"){$m="มีนาคม";}
			if($mm=="03"){$m="มีนาคม";}
			if($mm=="04"){$m="เมษายน";}
			if($mm=="05"){$m="พฤษภาคม";}
			if($mm=="06"){$m="มิถุนายน";}
			if($mm=="07"){$m="กรกฎาคม";}
			if($mm=="08"){$m="สิงหาคม";}
			if($mm=="09"){$m="กันยายน";}
			if($mm=="10"){$m="ตุลาคม";}
			if($mm=="11"){$m="พฤศจิกายน";}
			if($mm=="12"){$m="ธันวาคม";}
			$y=$yy+543;
			$time=substr($day,11,5);
			$data = $dd." ".$m." ".$y." ".$time." น. ";
	
			return $data;
			}else{
			echo "ไม่ระบุวันที่";
			}
			}
	

		function month($data){
		$day=$data;
		$mm=substr($day,5,2);
		$yy=substr($day,0,4);		
		if($mm=="01"){$m="มกราคม";}
		if($mm=="02"){$m="กุมภาพันธ์";}
		if($mm=="03"){$m="มีนาคม";}
		if($mm=="04"){$m="เมษายน";}
		if($mm=="05"){$m="พฤษภาคม";}
		if($mm=="06"){$m="มิถุนายน";}
		if($mm=="07"){$m="กรกฎาคม";}
		if($mm=="08"){$m="สิงหาคม";}
		if($mm=="09"){$m="กันยายน";}
		if($mm=="10"){$m="ตุลาคม";}
		if($mm=="11"){$m="พฤศจิกายน";}
		if($mm=="12"){$m="ธันวาคม";}
		$y=$yy+543;
		$data = $m." ".$y;
		return $data;
		}

		function getSMonth($mm){
		if($mm=="1"){$m="ม.ค.";}
		if($mm=="2"){$m="ก.พ.";}
		if($mm=="3"){$m="มี.ค.";}
		if($mm=="4"){$m="เม.ย.";}
		if($mm=="5"){$m="พ.ค.";}
		if($mm=="6"){$m="มิ.ย.";}
		if($mm=="7"){$m="ก.ค.";}
		if($mm=="8"){$m="ส.ค.";}
		if($mm=="9"){$m="ก.ย.";}
		if($mm=="10"){$m="ต.ค.";}
		if($mm=="11"){$m="พ.ย.";}
		if($mm=="12"){$m="ธ.ค.";}
		return $m;
		}

		function getMonth($mm){
		if($mm=="1"){$m="มกราคม";}
		if($mm=="2"){$m="กุมภาพันธ์";}
		if($mm=="3"){$m="มีนาคม";}
		if($mm=="3"){$m="มีนาคม";}
		if($mm=="4"){$m="เมษายน";}
		if($mm=="5"){$m="พฤษภาคม";}
		if($mm=="6"){$m="มิถุนายน";}
		if($mm=="7"){$m="กรกฎาคม";}
		if($mm=="8"){$m="สิงหาคม";}
		if($mm=="9"){$m="กันยายน";}
		if($mm=="10"){$m="ตุลาคม";}
		if($mm=="11"){$m="พฤศจิกายน";}
		if($mm=="12"){$m="ธันวาคม";}
		return $m;
		}

		function changeday($day){
			$dd=substr($day,8,2);
			$mm=substr($day,5,2);
			$yy=substr($day,0,4);
			if($yy>="2540"){
			$y=$yy-543;
			}else{$y=$yy;}
			$data=$y."-".$mm."-".$dd;
			return $data;
		}


		function homcdate($day){
			$dd=substr($day,8,2);
			$mm=substr($day,5,2);
			$yy=substr($day,0,4);
			
			$y=$yy+543;
			
			$data=$y.$mm.$dd;
			return $data;
		}

		
	

		function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }

		function RandomString() { 
			  $length = 14; 
			  $letters = '1234567890qwertyuiopasdfghjklzxcvbnm';
			  $s = ''; 
			  $lettersLength = strlen($letters)-1; 
			  
			  for($i = 0 ; $i < $length ; $i++) 
			  { 
			  $s .= $letters[rand(0,$lettersLength)]; 
			  } 
			  return $s; 
		  } 

		  function newHN($hn){
			$len=strlen($hn);
			if($len=="7"){$newhn=$hn;}
			if($len=="6"){$newhn=" ".$hn;}
			if($len=="5"){$newhn="  ".$hn;}
			if($len=="4"){$newhn="   ".$hn;}
			if($len=="3"){$newhn="    ".$hn;}
			if($len=="2"){$newhn="     ".$hn;}
			if($len=="1"){$newhn="      ".$hn;}
			return $newhn;
		}

}
?>