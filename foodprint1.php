<?php session_start();
    date_default_timezone_set('Asia/Bangkok');
    require_once('mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
    ob_start(); // ทำการเก็บค่า html นะครับ
    $admin_user=$_SESSION["admin_user"];
    //$wid=$_SESSION["wid"];
require_once("function.php");
$obj=new ConnDB();
$obj->connMS();
$serverName = "192.168.28.3"; //serverName ชื่อ Server
$connectionInfo = array( "Database"=>"HOMC", "UID"=>"homc", "PWD"=>"homc","MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);


$sqlward=sqlsrv_query($conn,"select * from Ward order by ward_name asc");
 while($rowward=sqlsrv_fetch_object($sqlward)){

$sql = sqlsrv_query($conn,"select i.hn,i.regist_flag,i.ladmit_n,CAST(RTRIM(t.titleName) + RTRIM(p.firstName) + '  ' + RTRIM(p.lastName) AS CHAR(50)) AS Name,w.ward_id,w.ward_name,dbo.ymd2cbe(i.admit_date) as date,dbo.nowage(p.birthDay,dbo.ce2ymd(getdate()))as age from Ipd_h i left join PATIENT p on (p.hn=i.hn) left join Ward w on(w.ward_id = i.ward_id) LEFT JOIN PTITLE t ON (p.titleCode = t.titleCode) where i.ward_id = '$rowward->ward_id'  and i.discharge_status='0' order by p.firstName asc");//เลือกข้อมูล
$numpatient = $obj->msAll("select count(*) as allpatient from Ipd_h i  where ward_id = '$rowward->ward_id'  and discharge_status='0'");//เลือกข้อมูล
$wd=$obj->msQuery(" Ward "," where ward_id='$rowward->ward_id'");
?>
<table style="border: 1px solid black;border-collapse:collapse;width:100%">
<thead>
<tr>
<th style="border: 1px solid black;font-family: THSarabun;font-size:12px">#</th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:60px;">HN</th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:12px">ชื่อ-สกุล</th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:60px;"><b>อายุ</b></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:12px">เตียง</th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:12px">การวินิจฉัย</th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">ธรรมดา</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">อ่อน</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">อ่อน<br>จืด</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">อ่อน<br>จืด<br>เบาหวาน</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">อ่อน<br>เบาหวาน</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">ธรรมดา<br>จืด</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">ธรรมดา<br>จืด<br>เบาหวาน</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">ธรรมดา<br>เบาหวาน</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:10px;width:60px;">ธรรมดา<br>งดสัตว์ปีก</span></font></th>
<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;">หมายเหตุ</span></font></th>
</tr>
</thead>
<tbody>
<?php

$n=0;
while($row = sqlsrv_fetch_object($sql)){
    $obj->construct();
    $shows=$obj->getQuery(" foods "," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$rowward->ward_id' and dc='0' order by datetimed desc");

    $specials=$obj->getQuery(" specialfoods "," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$rowward->ward_id' and dc='0'");
if($shows->kind!='' || $shows->note != ''){
	$n=$n+1;
?>
<tr>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px"><?php echo $n;?></td>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px"><?php echo $row->hn;?></td>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px"><?php echo $row->Name;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px;letter-spacing: 1px;"><?php echo $row->age;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px"><?php echo $shows->bed;?></td>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:120px;"><?php echo $shows->diag;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px">
<? if($shows->kind=="1"){?><img src="images/ck.jpg"><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="2"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="3"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="4"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="5"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="6"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="7"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="8"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="9"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: left;font-size:10px">

<?php 
 $sp=$obj->getFetch(" select * from specialfoods  where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$rowward->ward_id' and dc='0'");
$numsp=$obj->numrows(" specialfoods "," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$rowward->ward_id' and dc='0'");
while($rowsp=$sp->fetch_object()){
	$rowsspecial=$obj->getQuery(" special "," where id='$rowsp->special' ");echo $rowsspecial->name.",";

}
?>
<?php if(!empty($shows->note)){ echo $shows->note;}?>
</td>
</tr>
<?php }else{
if(!empty($shows->note) && empty($shows->category)){
	$n=$n+1;
?>

<tr>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px"><?php echo $n;?></td>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px"><?php echo $row->hn;?></td>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px"><?php echo $row->Name;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px;letter-spacing: 1px;"><?php echo $row->age;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px"><?php echo $shows->bed;?></td>
<td style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:120px;"><?php echo $shows->diag;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px">
<? if($shows->kind=="1"){?><img src="images/ck.jpg"><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="2"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="3"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="4"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="5"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="6"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="7"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="8"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;">
<? if($shows->kind=="9"){?><img src="./images/ck.jpg" width="16" /><?}?>
</td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: left;font-size:10px">

<?php 
 $sp=$obj->getFetch(" select * from specialfoods  where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$rowward->ward_id' and dc='0'");
$numsp=$obj->numrows(" specialfoods "," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$rowward->ward_id' and dc='0'");
while($rowsp=$sp->fetch_object()){
	$rowsspecial=$obj->getQuery(" special "," where id='$rowsp->special' ");echo $rowsspecial->name.",";

}
?>
<?php if(!empty($shows->note)){ echo $shows->note;}?>
</td>
</tr>
<?php }}} ?>
</tbody>	
</table>
<pagebreak>
<table style="border: 1px solid black;border-collapse:collapse;width:100%">
  <tr> 
    <th style="border: 1px solid black;font-family: THSarabun;font-size:12px" colspan="3">รวม</th>
    <th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >ธรรมดา</span></font></th>
    <th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >อ่อน</span></font></th>
    <th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >อ่อน<br>จืด</span></font></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >อ่อน<br>จืด<br>เบาหวาน</span></font></th>
    <th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >อ่อน<br>เบาหวาน</span></font></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >ธรรมดา<br>จืด</span></font></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >ธรรมดา<br>จืด<br>เบาหวาน</span></font></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >ธรรมดา<br>เบาหวาน</span></font></th>
    <th style="border: 1px solid black;font-family: THSarabun;font-size:10px" >ธรรมดา<br>งดสัตว์ปีก</span></font></th>
  </tr>
<tr> 
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;" colspan="3">
	<?   $obj->construct();	$fdall=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and (kind<>'' or kind is not null) and dc='0' "); echo $n;?> ราย
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd1=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='1' and dc='0' "); echo $fd1->val;?>
	</td>
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd2=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='2' and dc='0'"); echo $fd2->val;?>
	</td>
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd3=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='3' and dc='0'"); echo $fd3->val;?>
	</td>
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd4=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='4' and dc='0'"); echo $fd4->val;?>
	</td>
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd5=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='5' and dc='0'"); echo $fd5->val;?>
	</td>
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd6=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='6' and dc='0' "); echo $fd6->val;?>
	</td>
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd7=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='7' and dc='0'"); echo $fd7->val;?>
	</td>
    <td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd8=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='8' and dc='0'"); echo $fd8->val;?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:70px;">
	<? 	$fd9=$obj->getAll("select count(distinct hn) as val from foods where ward_id='$rowward->ward_id' and kind='9' and dc='0'"); echo $fd9->val;?>
	</td>
  </tr>
  </table>



<br>



<table style="border: 1px solid black;border-collapse:collapse;width:100%">
	<tr>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:20px;" ><b>#</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:60px;" ><b>HN</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:150px;" ><b>ชื่อ-สกุล</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:60px;" ><b>อายุ</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px" ><b>การวินิจฉัย</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" ><b>โรค</b></th>	
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" ><b>เหลวใส</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" ><b>นมกล่อง</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" ><b>BD 1:1</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" ><b>BD 1.2 :1</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" ><b>BD 1.5:1</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" ><b>BD 2:1</b></th>

	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" > <b>20 CAL</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" > <b>24 CAL</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" > <b>27 CAL</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" > <b>30 CAL</b></th>
	<th style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:70px;" > <b>หมายเหตุ </b></th>
	</tr>

<?
$sql=$obj->getFetch("select * from foods where ward_id='$rowward->ward_id' and category<>'' and dc='0' group by hn  order by datetimed desc");

$n=0;
while($rowsa=$sql->fetch_object()){

//if($rowsa->foodsize1>0){
$hn=$rowsa->hn;
	$n=$n+1;
?>
<tr>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px">
	<?
		echo $n;
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;font-size:12px">
	<?
		echo $hn;
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;font-size:12px">
	<?

		$obj->connMS();
		$result = $obj->msAll("select CAST(RTRIM(t.titleName) + RTRIM(p.firstName) + '  ' + RTRIM(p.lastName) AS CHAR(50)) AS Name,dbo.nowage(p.birthDay,dbo.ce2ymd(getdate()))as age from PATIENT p LEFT JOIN PTITLE t ON (p.titleCode = t.titleCode) where hn='$rowsa->hn'");//เลือกข้อมูล
		
		echo $result->Name;
		 $obj->construct();
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:40px;font-size:12px">
	<?
		echo $result->age;
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;font-size:12px;width:120px;">
	<?
		echo $rowsa->diag;
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='1'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2;}
	?>
	</td>
	
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='2'){echo $rowsa->foodsize1." กล่อง/วัน ".$rowsa->foodsize2;}
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='3'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2;if($rowsa->dm=="1"){echo "(DM)";}if($rowsa->ckd=="1"){echo "(CKD)";}}
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='7'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2;if($rowsa->dm=="1"){echo "(DM)";}if($rowsa->ckd=="1"){echo "(CKD)";}}
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='4'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2;if($rowsa->dm=="1"){echo "(DM)";}if($rowsa->ckd=="1"){echo "(CKD)";}}
	?>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='5'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2;if($rowsa->dm=="1"){echo "(DM)";}if($rowsa->ckd=="1"){echo "(CKD)";}}
	?>
	</td>
	
	
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='8'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2." ขวด";}
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='9'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2." ขวด";}
	?>
	</td>

	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='10'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2." ขวด";}
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;width:60px;font-size:12px">
	<?
		if($rowsa->category=='11'){echo $rowsa->foodsize1." ซีซี x ".$rowsa->foodsize2." ขวด";}
	?>
	</td>
	<td style="border: 1px solid black;font-family: THSarabun;text-align: center;font-size:12px">
	<?
		 if(!empty($rowsa->note)){echo $rowsa->note.",";}
	?>
	<? 
$rowsspecial=$obj->getFetch("select * from specialfoods where hn='$rowsa->hn' and vn='$rowsa->regist_flag' and ward_id='$rowward->ward_id' ");
$n=0;
$num=$obj->numrows("specialfoods"," where hn='$rowsa->hn' and vn='$rowsa->regist_flag' and ward_id='$rowward->ward_id' ");
while($rspecial=$rowsspecial->fetch_object()){
$n=$n+1;
    $specials=$obj->getQuery(" special "," where id='$rspecial->special'");
    echo $specials->name;if($n<$num){echo ",";}
}
    ?>
	</td>

	
	
</tr>
<?php }//}?>
</table>

<?php }?>




<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban',1, 1, 30, 1); //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
$pdf->SetHTMLHeader('<div align="center">หอผู้ป่วย'.$wd->ward_name.'('.$wd->ward_id.') ยอดผู้ป่วยทั้งหมด '. $numpatient->allpatient.' ราย</div><div align="center"> วันที่ '.$obj->showdatetime($obj->getdatetime()).'</div>');
$pdf->autoScriptToLang = false;
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();
?>