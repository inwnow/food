<? session_start();
@header("Content-Type: text/html; charset=tis-620");
require_once("function.php");
$obj=new ConnDB();
$admin_user=$_SESSION["admin_user"];
$wid=$_SESSION["wid"];
$day=$obj->getday();
$ip=$obj->getIP();
$datetimed=$obj->getdatetime();
?>
<?
switch($op){
case "1": {
		$obj->construct();

		$chk=$obj->numrows(" foods "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
		if($chk<=0){
			$obj->getInsertfield(" foods ","hn,vn,$field,ward_id,day,datetimed,ip"," '$hn','$vn','$val','$wid','$day','$datetimed','$ip' ");
		}else{
			$chks=$obj->numrows(" foods "," where hn='$hn' and vn='$vn' and kind='$val' and ward_id='$wid'");
			if($chks=="0"){
			$obj->getUpdate(" foods "," $field='$val' "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
			}else{
			$obj->getUpdate(" foods "," kind=NULL "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
			}

		}

		echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=http://192.168.20.11/food/index.php?files=orders&hn='.$hn.'&vn='.$vn.'">';

} break;

case "2": {
	$obj->construct();

	$chk=$obj->getQuery(" foods "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
	if($chk<=0){
		$obj->getInsertfield(" foods ","hn,vn,category,$field,ward_id,day,datetimed,ip"," '$hn','$vn','$category','$val','$wid','$day','$datetimed','$ip' ");
	}else{
		if($val=="0"||$val==""){
		$obj->getUpdate(" foods "," category=NULL,$field=NULL "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
		}else{
		$obj->getUpdate(" foods "," category='$category',$field='$val' "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
		}
	}

} break;

case "3": {
	$obj->construct();

	$chk=$obj->getQuery(" specialfoods "," where hn='$hn' and vn='$vn' and ward_id='$wid' and $field='$val'");
	if($chk<=0){
		$obj->getInsertfield(" specialfoods ","hn,vn,$field,ward_id,usercode,day,datetimed,ip"," '$hn','$vn','$val','$wid','$admin_user','$day','$datetimed','$ip' ");
	}else{
		$obj->getUpdate(" specialfoods "," $field='$val' "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
	}

} break;


case "4": {
	$obj->construct();

	$chk=$obj->getQuery(" foods "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
	if($chk<=0){
		$obj->getInsertfield(" foods ","hn,vn,category,$field,ward_id,day,datetimed,ip"," '$hn','$vn','$category','$val','$wid','$day','$datetimed','$ip' ");
	}else{
		$obj->getUpdate(" foods "," $field='$val' "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
	}

} break;

case "5": {
	$obj->construct();

	$chk=$obj->getQuery(" foods "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
	if($chk<=0){
		$obj->getInsertfield(" foods ","hn,vn,category,$field,ward_id,day,datetimed,ip"," '$hn','$vn','$category','$val','$wid','$day','$datetimed','$ip' ");
	}else{
		$obj->getUpdate(" foods "," $field='$val' "," where hn='$hn' and vn='$vn' and ward_id='$wid'");
	}

} break;

}
?>