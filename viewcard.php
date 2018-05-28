<?php session_start();
    date_default_timezone_set('Asia/Bangkok');
    require_once('mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
    ob_start(); // ทำการเก็บค่า html นะครับ
    $admin_user=$_SESSION["admin_user"];
    $wid=$_SESSION["wid"];
require_once("function.php");
$obj=new ConnDB();
$serverName = "192.168.28.3"; //serverName ชื่อ Server
$connectionInfo = array( "Database"=>"HOMC", "UID"=>"homc", "PWD"=>"homc","MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);
$n=0;
//$sql=$obj->getFetch("select * from foods where ward_id='$wid' and kind<>''  and dc='0'");
$sqls= sqlsrv_query($conn,"select i.hn,i.regist_flag,i.ladmit_n,CAST(RTRIM(t.titleName) + RTRIM(p.firstName) + '  ' + RTRIM(p.lastName) AS CHAR(50)) AS Name,w.ward_id,w.ward_name,dbo.ymd2cbe(i.admit_date) as date,dbo.nowage(p.birthDay,dbo.ce2ymd(getdate())) as age from Ipd_h i left join PATIENT p on (p.hn=i.hn) left join Ward w on(w.ward_id = i.ward_id) LEFT JOIN PTITLE t ON (p.titleCode = t.titleCode) where i.ward_id = '$wid'  and i.discharge_status='0' order by p.firstName asc");//เลือกข้อมูล
$num=sqlsrv_num_rows($sqls);
while($rows = sqlsrv_fetch_object($sqls)){
$obj->construct();
$row=$obj->getQuery(" foods "," where ward_id='$rows->ward_id' and hn='$rows->hn' and vn='$rows->regist_flag' ");
$n=$n+1;
if($row->kind != '' || $row->note!= ''){
    ?>
<table width="100%">    
<tr>
<td>หอผู้ป่วย</td>
<td><?php echo $rows->ward_name;?></td>
</tr>
<tr>
<td>เตียง <?php echo $row->bed;?></td>
<td><?php echo $rows->Name;?></td>
</tr>
<tr>
<td>อาหาร</td>
<td><?php $kind=$obj->getQuery(" kind "," where id='$row->kind'");echo $kind->name;?></td>
</tr>
<tr>
<td>พลังงาน</td>
<td><?php echo $kind->kcal;?> Kcal.</td>
</tr>
<tr>
<td>หมายเหตุ</td>
<td style="font-size:10px"><?php echo $row->note;?> <?php 
$spacial=$obj->getFetch(" select * from specialfoods  where hn='$row->hn' and vn='$row->vn'");
	$i=0;
	$nums=$obj->numrows(" specialfoods "," where hn='$row->hn' and vn='$row->vn' ");
while($rowspacial=$spacial->fetch_object()){ 
	$i=$i+1;
	$fs=$obj->getQuery(" special "," where id='$rowspacial->special'");
	echo $fs->name;
	if($i<$nums){echo ",";}
	}
	?></td>
</tr>
<tr>
<td colspan="2"><hr>หน้าที่ <?php echo $n;?>/<?php echo $num;?> <?php echo $obj->showdatetime(date("Y-m-d:H:i:s"));?></td>
</tr>
</table>
<?php if($n<$num){?>
<pagebreak>
<?php }}?>
<?php }?>


<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf=new mPDF('tha',array(80,51),'','','1','1','1','1','','1');
$pdf->autoScriptToLang = false;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);

$pdf->Output();
?>