<?php
	include("../db_pdo_conn.php");
	$userName = $_SESSION['userName'];
	$exhibition_id = $_POST['id'];
	$select = "SELECT * FROM member WHERE userName = '".$userName."'";
	$result = $db->query($select);
	$row = $result->fetch();
	if($row[4]){//有訂閱
	
		$temp = unserialize($row[4]);
		array_push($temp, $exhibition_id);
		$sub_exhibition = serialize($temp);
		
	}else{//無訂閱或無資料
	
		if($row[0]){//無資料
			echo "no such user";
		}else{//無訂閱
			$temp = array();
			array_push($temp, $exhibition_id);
			$sub_exhibition = serialize($temp);
		}
		
	}
	$update = "UPDATE member SET exhibition_subed = '".$sub_exhibition."' WHERE userName = '".$userName."'";
	//$exhibition_subed = unserialize($row[4]);
	
	
?>