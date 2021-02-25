<?php

	/*
		使用者登入 -> 改變status
		回傳使用者、登入狀態和所訂閱的展場
	*/
	include("../db_pdo_conn.php");
	session_start();
	$un = $_POST['userName'];
	$password = $_POST['password'];	
	
	class userInfo{
		var $userName;
		var $status;
		var $exhibitionList;
		var $versionList;
	   	 
		function userInfo($userName, $status, $exhibitionList, $versionList){
			$this->userName = $userName;
			$this->status = $status;
			$this->exhibitionList = $exhibitionList;
			$this->versionList = $versionList;
		}
	}
	
	check($un, $password, $db);
	
	//function
	function check($un, $password, $db){
		$versionList = array();
		$check = "SELECT * FROM member WHERE userName = '".$un."' AND password = '".$password."'";
		$result = $db->query($check);
		$row = $result->fetch();
		if($row[0] != NULL){
			$update = "UPDATE member SET status = 1 WHERE userName = '".$un."' AND password = '".$password."'";
			$db->query($update);
			$_SESSION['userName'] = $row[0];
			$_SESSION['password'] = $row[1];
			$exhibitionList = unserialize($row[4]);//訂閱的展場
			if($exhibitionList != NULL){
				foreach($exhibitionList as $item){
					$select = "SELECT version FROM exhibition WHERE exhibition_id = '".$item."'";
					$v_result = $db->query($select);
					$v_row = $v_result->fetch();
					array_push($versionList, $v_row[0]);
				}
			}
			$userInfo = new userInfo($row[0], 1, $exhibitionList, $versionList);
			echo json_encode($userInfo);//有此資料
		}else{
			$userInfo = new userInfo(NULL, 0, NULL, NULL);
			echo json_encode($userInfo);//無此資料
		}
	}
	
	/*
	function selectBeacon($exhibitionList, $exhibition_id){
		$select = "SELECT * FROM beacon WHERE exhibition_id = '".$exhibition_id."'";
		$select_sql = $db->prepare($select); 
		$select_sql->execute();
		$result = $db->query($select);
		$row_total = $select_sql->rowCount();
		$beaconArray = array();
		for($i = 0;$i < $row_total;$i++){
			$row = $result->fetch();
			$beaconArray = new beacon($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
			array_push($beaconArray,$beacon);	
		}
		return $beaconArray;
	}
	*/
?>