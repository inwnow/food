<?php session_start();
require_once("function.php");
	$obj=new ConnDB();
	$obj->ConnMS(); 
	if(!empty($usr) and !empty($pwd)){
		$pwds=strtoupper(md5($pwd));
		$row = $obj->msQuery("  profile "," where UserCode='$usr' and PassCode='$pwds' ");//เลือกข้อมูล
	if(!empty($row->UserCode)){
		$admin_user=$row->UserCode;
				$_SESSION["admin_user"]=$admin_user;
				header("Location: index.php?files=foodview");
	}else{
				header("Location: index.php");
	}
	}
?>
