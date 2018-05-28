<?php session_start();
require_once("function.php");
$obj=new ConnDB();

$serverName = "192.168.28.3"; //serverName ชื่อ Server
$connectionInfo = array( "Database"=>"HOMC", "UID"=>"homc", "PWD"=>"homc","MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);
$obj->construct();
$chks=$obj->getFetch(" select * from foods where ward_id='$wid' and dc='0'");
while($rowchk=$chks->fetch_object()){
$obj->connMS();
$chkup=$obj->msQuery(" Ipd_h "," where hn='$rowchk->hn' and regist_flag='$rowchk->vn' order by regist_flag desc");
$obj->construct();
$obj->getUpdate(" foods "," dc='$chkup->discharge_status',ward_id='$chkup->ward_id'"," where hn='$rowchk->hn' and vn='$chkup->regist_flag'");
$obj->getUpdate(" specialfoods "," dc='$chkup->discharge_status',ward_id='$chkup->ward_id'"," where hn='$rowchk->hn' and vn='$chkup->regist_flag'");
}



?>
<table class="table bordered striped highlight" border="1">
<thead>
<tr>
<th></th>
<th>HN</th>
<th>เตียง</th>
<th>ชื่อ-สกุล</th>
<th>อายุ</th>
<th>การวินิจฉัย</th>
<th>อาหาร</th>
<th>อาหารเพิ่มเติม</th>
<th>หมายเหตุ</th>
</tr>
</thead>
<tbody>
<?php
$m=0;
$sql = sqlsrv_query($conn,"select i.hn,i.regist_flag,i.ladmit_n,CAST(RTRIM(t.titleName) + RTRIM(p.firstName) + '  ' + RTRIM(p.lastName) AS CHAR(50)) AS Name,w.ward_id,w.ward_name,dbo.ymd2cbe(i.admit_date) as date,dbo.nowage(p.birthDay,dbo.ce2ymd(getdate())) as age from Ipd_h i left join PATIENT p on (p.hn=i.hn) left join Ward w on(w.ward_id = i.ward_id) LEFT JOIN PTITLE t ON (p.titleCode = t.titleCode) where i.ward_id = '$wid'  and i.discharge_status='0' order by p.firstName asc");//เลือกข้อมูล
while($row = sqlsrv_fetch_object($sql)){
	$m=$m+1;
    $obj->construct();

    $showfood=$obj->getQuery(" foods "," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$wid' and dc='0' ");

	$rowskind=$obj->getQuery(" kind "," where id='$showfood->kind' ");
	 $max=$obj->getAll(" select max(day) as nowday from foods where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$wid' ");
	 
	 $chks=$obj->getFetch(" select * from foods where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$wid' and day<'$max->nowday' ");
	 while($rowchks=$chks->fetch_object()){
		 $obj->getUpdate(" foods "," dc='1' "," where hn='$rowchks->hn' and vn='$rowchks->vn' and day='$rowchks->day' and ward_id='$wid' ");

	 }


   $bd=$obj->getQuery(" category "," where id='$showfood->category'");

?>
<tr>
<td style="text-align:center"><font size="3" color="#009900"><i class="material-icons tooltipped" data-position="right" data-delay="50" <?php if(empty($showfood->hn)){?>data-tooltip="เบิกอาหาร"<?php }else{?>data-tooltip="เปลี่ยนอาหาร"<?php }?> onclick="location='index.php?files=orders&hn=<?php echo $row->hn;?>&vn=<?php echo $row->regist_flag;?>'" style="cursor:pointer"><?php if(empty($showfood->hn)){?>add_circle_outline<?php }else{?>edit<?php }?></i></font></td>
<td><?php echo $row->hn;?></td>
<td><?php echo $showfood->bed;?></td>
<td><?php echo $row->Name;?></td>
<td><?php echo $row->age;?></td>
<td><?php echo $showfood->diag;?></td>
<td>
<? echo $rowskind->name;?> 
<?php echo $bd->name;?> 
<?php if(!empty($showfood->foodsize1)){echo $showfood->foodsize1." ซีซี x ".$showfood->foodsize2;}?> 
<?php //if($showfood->category=="8"||$showfood->category=="9"){echo $showfood->foodsize2." ขวด";}?>
</td>
<td>
<? 
$rowsspecial=$obj->getFetch("select * from specialfoods where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$wid' ");
$n=0;
$num=$obj->numrows("specialfoods"," where hn='$row->hn' and vn='$row->regist_flag' and ward_id='$wid' ");
while($rspecial=$rowsspecial->fetch_object()){
$n=$n+1;
    $specials=$obj->getQuery(" special "," where id='$rspecial->special'");
    echo $specials->name;if($n<$num){echo ",";}
}
    ?></td>
<td><?php echo $showfood->note;?></td>
</tr>
<?php  }//} ?>
</tbody>	
</table>