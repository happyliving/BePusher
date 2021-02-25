<?php
	include("../db_pdo_conn.php");
	session_start();
	class userInfo{
		var $userName;
		var $status;
		var $exhibitionList;
	   	 
		function userInfo($userName, $status, $exhibitionList){
			$this->userName = $userName;
			$this->status = $status;
			$this->exhibitionList = $exhibitionList;
		}
	}
	if(isset($_SESSION['userName'])){
		$check = "SELECT * FROM member WHERE userName = '".$_SESSION['userName']."' AND password = '".$_SESSION['password']."'";
		$result = $db->query($check);
		$row = $result->fetch();
		$exhibitionList = unserialize($row[4]);
		$userInfo = new userInfo($_SESSION['userName'], 1, $exhibitionList);
		echo json_encode($userInfo);//已登入
	}
	else{
		$userInfo = new userInfo(NULL, 0, NULL);
		echo json_encode($userInfo);//未登入
	}
?>