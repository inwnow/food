<?php session_start();
    date_default_timezone_set('Asia/Bangkok');
    require_once('mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
    ob_start(); // ทำการเก็บค่า html นะครับ
    $admin_user=$_SESSION["admin_user"];
    //$wid=$_SESSION["wid"];
require_once("function.php");
$obj=new ConnDB();

//$serverName = "192.168.28.3"; //serverName ชื่อ Server
//$connectionInfo = array( "Database"=>"HOMC", "UID"=>"homc", "PWD"=>"homc","MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
//$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>

<?
$obj->construct();
$n=0;
$sql=$obj->getFetch("select * from foods where ward_id='$ward_id' and category<>'' and dc='0' GROUP BY hn ");
$num=$obj->numrows(" foods "," where ward_id='$ward_id' and category<>'' and dc='0'  GROUP BY hn");
while($row=$sql->fetch_object()){
    $n=$n+1;
    $obj->connMS();
    $wrd=$obj->msQuery(" Ward "," where ward_id='$ward_id'");
	if($row->foodsize1>0){
    ?>
<table width="100%">    
<tr>
<td style="font-size:12px">หอผู้ป่วย</td>
<td><?php echo $wrd->ward_name;?></td>
</tr>
<tr>
<td style="font-size:12px">เตียง <?php echo $row->bed;?></td>
<td><?php $patient=$obj->msAll(" select t.titleName,p.firstName,p.lastName from PATIENT p LEFT JOIN PTITLE t on (p.titleCode=t.titleCode) where p.hn='$row->hn'");echo trim($patient->titleName).$patient->firstName." ".$patient->lastName;?></td>
</tr>
<tr>
<td style="font-size:12px">อาหาร</td>
<td><?php $obj->construct();$kind=$obj->getQuery(" category "," where id='$row->category'");echo $kind->name;?> <?php echo $row->foodsize1;?> ซีซี x <?php echo $row->foodsize2;?></td>
</tr>
<tr>
<td style="font-size:12px">พลังงาน</td>
<td><?php echo $kind->kcal*$row->foodsize1*4;?> Kcal.</td>
</tr>
<tr>
<td style="font-size:12px">หมายเหตุ</td>
<td style="font-size:12px"><?php 
$spacial=$obj->getFetch(" select * from specialfoods  where hn='$row->hn' and vn='$row->vn'");
	$i=0;
	$nums=$obj->numrows(" specialfoods "," where hn='$row->hn' and vn='$row->vn' ");
while($rowspacial=$spacial->fetch_object()){ 
	$i=$i+1;
	$fs=$obj->getQuery(" special "," where id='$rowspacial->special'");
	echo $fs->name;
	if($i<$nums){echo ",";}
	}
	?><?php echo $row->note;?></td>
</tr>
<tr>
<td colspan="2" style="font-size:12px"><hr>หน้าที่ <?php echo $n;?>/<?php echo $num;?> <?php echo $obj->shortdatetime(date("Y-m-d:H:i:s"));?> <?php if($meal=='1'){echo "(เช้า : 8.00 น.)";}?><?php if($meal=='2'){echo "(บ่าย : 14.00 น.)";}?></td>
</tr>
</table>
<?php if($n<$num){?>
<pagebreak>
<?php }?>
<?php }}?>






<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf=new mPDF('tha',array(80,51),'','','1','1','1','1','','1');
$pdf->autoScriptToLang = false;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);

$pdf->Output();
?>