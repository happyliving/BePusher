<?php
	include("../db_pdo_conn.php");
	$userName = $_POST['userName'];
	$password = $_POST['password'];
	$authority = false;//(管理員/客人)權限
	$status = false;//(登入/登出)狀態，註冊完即為登入狀態
	$null = NULL;
	if(checkExist($userName, $db)){
		$register = "INSERT INTO member VALUES('$userName','$password','$authority','$status','$null')";
		$db->query($register);
	}
	
	
	//function
	function checkExist($userName, $db){
		$check = "SELECT * FROM member WHERE userName = '".$userName."'";
		$checkUN = $db->query($check);
		if($checkUN->fetch()){
			echo 1;//重複UN
			return false;
		}
		echo 0;//沒重複
		return true;
	}
?>