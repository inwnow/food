<?php session_start();
			 session_destroy();
			require_once("function.php");
			$obj=new ConnDB();
			$obj->getmain("index.php");
			exit();
?>
<center><a <?=$obj->a("index.php");?>>ออกจากระบบ</a></center>