<?php session_start();
    date_default_timezone_set('Asia/Bangkok');
    require_once('mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
    ob_start(); // ทำการเก็บค่า html นะครับ
    $admin_user=$_SESSION["admin_user"];
    $wid=$_SESSION["wid"];
require_once("function.php");
$obj=new ConnDB();
$obj->connMS();
$serverName = "192.168.28.3"; //serverName ชื่อ Server
$connectionInfo = array( "Database"=>"HOMC", "UID"=>"homc", "PWD"=>"homc","MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);
$sql = sqlsrv_query($conn,"select i.hn,i.regist_flag,i.ladmit_n,CAST(RTRIM(t.titleName) + RTRIM(p.firstName) + '  ' + RTRIM(p.lastName) AS CHAR(50)) AS Name,w.ward_id,w.ward_name,dbo.ymd2cbe(i.admit_date) as date,dbo.nowage(p.birthDay,dbo.ce2ymd(getdate()))as age from Ipd_h i left join PATIENT p on (p.hn=i.hn) left join Ward w on(w.ward_id = i.ward_id) LEFT JOIN PTITLE t ON (p.titleCode = t.titleCode) where i.ward_id = '$wid'  and i.discharge_status='0' order by p.firstName asc");//เลือกข้อมูล
$numpatient = $obj->msAll("select count(*) as allpatient from Ipd_h i  where ward_id = '$wid'  and discharge_status='0'");//เลือกข้อมูล
$wd=$obj->msQuery(" Ward "," where ward_id='$wid'");
?>
<div align="center">หอผู้ป่วย<?php echo $wd->ward_name;?> ยอดผู้ป่วยทั้งหมด <?php echo $numpatient->allpatient;?> ราย</div>
<div align="center"> วันที่ <?php echo $obj->showdatetime($obj->getdatetime())?></div>
<table style="border: 1px solid black;border-collapse:collapse;width:100%">
<thead>
<tr>
<th style="border: 1px solid black;font-family: THSarabun;">HN</th>
<th style="border: 1px solid black;font-family: THSarabun;width:50px">เตียง</th>
<th style="border: 1px solid black;font-family: THSarabun;">ชื่อ-สกุล</th>
<th style="border: 1px solid black;font-family: THSarabun;width:50px">อายุ</th>
<th style="border: 1px solid black;font-family: THSarabun;width:150px">อาหาร</th>
<th style="border: 1px solid black;font-family: THSarabun;">อาหารพิเศษ</th>
<th style="border: 1px solid black;font-family: THSarabun;">หมายเหตุ</th>
</tr>
</thead>
<tbody>
<?php


while($row = sqlsrv_fetch_object($sql)){
    $obj->construct();
    $shows=$obj->getQuery(" foods "," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$wid'");
    $specials=$obj->getQuery(" specialfoods "," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$wid'");

?>
<tr>

<td style="border: 1px solid black;font-family: THSarabun;"><?php echo $row->hn;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: center;"><?php echo $shows->bed;?></td>
<td style="border: 1px solid black;font-family: THSarabun;"><?php echo $row->Name;?></td>
<td style="border: 1px solid black;font-family: THSarabun;text-align: right;"><?php echo $row->age;?></td>
<td style="border: 1px solid black;font-family: THSarabun;"><? $rowskind=$obj->getQuery(" kind "," where id='$shows->kind' ");echo $rowskind->name;?> <?php if(!empty($shows->foodsize1)){echo $shows->foodsize1." ซีซี";}?> <?php if(!empty($shows->foodsize2)){echo $shows->foodsize2." ขวด";}?></td>
<td style="border: 1px solid black;"><? $rowsspecial=$obj->getQuery("special"," where id='$specials->special' ");echo $rowsspecial->name;?></td>
<td style="border: 1px solid black;"><?php echo $shows->note;?></td>
</tr>
<?php  } ?>
</tbody>	
</table>

<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', ''); //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
$pdf->autoScriptToLang = false;
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();
?>