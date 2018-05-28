<?
session_start();
require_once("function.php");
$obj=new ConnDB();
?>
<table class="table bordered highlight">
<tr>
	<td align="center" style="vertical-align: middle"><b>หอผู้ป่วย/อาหาร</b></td>
	<td align="center"><span class="vertical"><b>ธรรมดา</b></span></td>
	<td align="center"><span class="vertical"><b>อ่อน</b></span></td>
	<td align="center"><span class="vertical"><b>เบาหวาน</b></span></td>
	<td align="center"><span class="vertical"><b>จืด</b></span></td>
	<td align="center"><span class="vertical"><b>งดสัตว์ปีก</b></span></td>
	<td align="center"><span class="vertical"><b>ไขมันน้อย</b></span></td>
	<td align="center"><span class="vertical"><b>กากน้อย</b></span></td>
	<td align="center"><span class="vertical"><b>เนื้อมาก</b></span></td>
	<td align="center"><span class="vertical"><b>เหลว 1</b></span></td>
	<td align="center"><span class="vertical"><b>นม</b></span></td>
	<td align="center"><span class="vertical"><b>BD 1:1</b></span></td>
	<td align="center"><span class="vertical"><b>BD 1.5:1</b></span></td>
	<td align="center"><span class="vertical"><b>BD 2:1</b></span></td>
	<td align="center"><span class="vertical"><b>BD 1:1 DM</b></span></td>
	<td align="center"><span class="vertical"><b>BD 0.5:1</b></span></td>
	<td align="center"><span class="vertical"><b>20 CAL </b></span></td>
	<td align="center"><span class="vertical"><b>24 CAL </b></span></td>
</tr>
<?php
$serverName = "192.168.28.3"; //serverName ชื่อ Server
$connectionInfo = array( "Database"=>"HOMC", "UID"=>"homc", "PWD"=>"homc","MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);
$sql1 = sqlsrv_query($conn,"select ward_id,ward_name from Ward order by ward_name");
while($result1 = sqlsrv_fetch_object($sql1)){
	$ward_id=$result1->ward_id;
	
?>
<tr>
	<td width="165"><?=$result1->ward_name;?></td>
	<td align="center">
	<?  $obj->construct();
        $row=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='1' and ward_id='$ward_id'");
		echo $row->val;
		$num1= $row->val;
		$v1=$v1+$num1;
	?>
	</td>
	<td align="center">
	<?
		$row2=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='2' and ward_id='$ward_id'");
		echo $row2->val;
		$num2= $row2->val;
		$v2=$v2+$num2;
	?>
	</td>
	<td align="center">
	<?
		$row3=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='3' and ward_id='$ward_id'");
		echo $row3->val;
		$num3= $row3->val;
		$v3=$v3+$num3;
	?>
	</td>
	<td align="center">
	<?
		$row4=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='4' and ward_id='$ward_id'");
		echo $row4->val;
		$num4= $row4->val;
		$v4=$v4+$num4;
	?>
	</td>
	<td align="center">
	<?
		$row5=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='5' and ward_id='$ward_id'");
		echo $row5->val;
		$num5= $row5->val;
		$v5=$v5+$num5;
	?>
	</td>
	<td align="center">
	<?
		$row6=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='6' and ward_id='$ward_id'");
		echo $row6->val;
		$num6= $row6->val;
		$v6=$v6+$num6;
	?>
	</td>
	<td align="center">
	<?
		$row7=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='7' and ward_id='$ward_id'");
		echo $row7->val;
		$num7= $row7->val;
		$v7=$v7+$num7;
	?>
	</td>
	<td align="center">
	<?
		$row8=$obj->getAll("select count(*) as val from foods where day='$fdate' and kind='8' and ward_id='$ward_id'");
		echo $row8->val;
		$num8= $row8->val;
		$v8=$v8+$num8;
	?>
	</td>
	<td align="center">
	<?
		$rows1=$obj->getAll("select sum(foodsize1) as val from foods where day='$fdate' and category='1' and ward_id='$ward_id'");
		echo $rows1->val;
		$nums1= $rows1->val;
		$vs1=$vs1+$nums1;
	?>
	</td>
	<td align="center">
	<?
		$rows2=$obj->getAll("select sum(foodsize1) as val from foods where day='$fdate' and category='2' and ward_id='$ward_id'");
		echo $rows2->val;
		$nums2= $rows2->val;
		$vs2=$vs2+$nums2;
	?>
	</td>
	<td align="center">
	<?
		$rows3=$obj->getAll("select sum(foodsize1) as val from foods where day='$fdate' and category='3' and ward_id='$ward_id'");
		echo $rows3->val;
		$nums3= $rows3->val;
		$vs3=$vs3+$nums3;
	?>
	</td>
	<td align="center">
	<?
		$rows4=$obj->getAll("select sum(foodsize1) as val from foods where day='$fdate' and category='4' and ward_id='$ward_id'");
		echo $rows4->val;
		$nums4= $rows4->val;
		$vs4=$vs4+$nums4;
	?>
	</td>
	<td align="center">
	<?
		$rows5=$obj->getAll("select sum(foodsize1) as val from foods where day='$fdate' and category='5' and ward_id='$ward_id'");
		echo $rows5->val;
		$nums5= $rows5->val;
		$vs5=$vs5+$nums5;
	?>
	</td>
	<td align="center">
	<?
		$rows6=$obj->getAll("select sum(foodsize1) as val from foods where day='$fdate' and category='6' and ward_id='$ward_id'");
		echo $rows6->val;
		$nums6= $rows6->val;
		$vs6=$vs6+$nums6;
	?>
	</td>
	<td align="center">
	<?
		$rows7=$obj->getAll("select sum(foodsize1) as val from foods where day='$fdate' and category='7' and ward_id='$ward_id'");
		echo $rows7->val;
		$nums7= $rows7->val;
		$vs7=$vs7+$nums7;
	?>
	</td>
	<td align="center">
	<?
		$rows8=$obj->getAll("select sum(foodsize1) as val1,sum(foodsize2) as val2 from foods where day='$fdate' and category='8' and ward_id='$ward_id'");
        echo $rows8->val1."ซีซี ";
        echo $rows8->val2."ขวด";
		$nums8= $rows8->val1;
		$vs8=$vs8+$nums8;
	?>
	</td>
	<td align="center">
	<?
		$rows9=$obj->getAll("select sum(foodsize1) as val1,sum(foodsize2) as val2 from foods where day='$fdate' and category='9' and ward_id='$ward_id'");
		echo $rows9->val1."ซีซี ";
        echo $rows9->val2."ขวด";
		$nums9= $rows9->val1;
		$vs9=$vs9+$nums9;
	?>
	</td>
</tr>
<?}?>
<tr>
	<td align="center"><b>รวม</b></td>
	<td align="center"><b><?=$v1;?></b></td>
	<td align="center"><b><?=$v2;?></b></td>
	<td align="center"><b><?=$v3;?></b></td>
	<td align="center"><b><?=$v4;?></b></td>
	<td align="center"><b><?=$v5;?></b></td>
	<td align="center"><b><?=$v6;?></b></td>
	<td align="center"><b><?=$v7;?></b></td>
	<td align="center"><b><?=$v8;?></b></td>
	<td align="center"><b><?=$vs1;?></b></td>
	<td align="center"><b><?=$vs2;?></b></td>
	<td align="center"><b><?=$vs3;?></b></td>
	<td align="center"><b><?=$vs4;?></b></td>
	<td align="center"><b><?=$vs5;?></b></td>
	<td align="center"><b><?=$vs6;?></b></td>
	<td align="center"><b><?=$vs7;?></b></td>
	<td align="center"><b><?=$vs8;?></b></td>
	<td align="center"><b><?=$vs9;?></b></td>
</tr>
<tr>
	<td align="center" style="vertical-align: middle"><b>หอผู้ป่วย/อาหาร</b></td>
	<td align="center"><span class="vertical"><b>ธรรมดา</b></span></td>
	<td align="center"><span class="vertical"><b>อ่อน</b></span></td>
	<td align="center"><span class="vertical"><b>เบาหวาน</b></span></td>
	<td align="center"><span class="vertical"><b>จืด</b></span></td>
	<td align="center"><span class="vertical"><b>งดสัตว์ปีก</b></span></td>
	<td align="center"><span class="vertical"><b>ไขมันน้อย</b></span></td>
	<td align="center"><span class="vertical"><b>กากน้อย</b></span></td>
	<td align="center"><span class="vertical"><b>เนื้อมาก</b></span></td>
	<td align="center"><span class="vertical"><b>เหลว 1</b></span></td>
	<td align="center"><span class="vertical"><b>นม</b></span></td>
	<td align="center"><span class="vertical"><b>BD 1:1</b></span></td>
	<td align="center"><span class="vertical"><b>BD 1.5:1</b></span></td>
	<td align="center"><span class="vertical"><b>BD 2:1</b></span></td>
	<td align="center"><span class="vertical"><b>BD 1:1 DM</b></span></td>
	<td align="center"><span class="vertical"><b>BD 0.5:1</b></span></td>
	<td align="center"><span class="vertical"><b>20 CAL </b></span></td>
	<td align="center"><span class="vertical"><b>24 CAL </b></span></td>
</tr>
</table>
