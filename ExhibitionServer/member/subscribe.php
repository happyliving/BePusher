<?php
//訂閱 或 取消訂閱
include "../db_pdo_conn.php";
session_start();
$exhibition_id = $_POST['id'];
$flag = $_POST['flag'];
if($flag == 1){
	storeUserExhibition($db, $exhibition_id);
}else{
	removeUserExhibition($db, $exhibition_id);
}

function storeUserExhibition($db, $exhibition_id){
	$userName = $_SESSION['userName'];
	$select = "SELECT * FROM member WHERE userName = '".$userName."'";
	$result = $db->query($select);
	$row = $result->fetch();
	
	if($row[4]){//有訂閱紀錄
		$temp = unserialize($row[4]);
		array_push($temp, $exhibition_id);
		$sub_exhibition = serialize($temp);	
	}else{//無訂閱紀錄
		if($row[0]){//有此使用者
			$temp = array();
			array_push($temp, $exhibition_id);
			$sub_exhibition = serialize($temp);
		}
	}
		
	$update = "UPDATE member SET exhibition_subed = '".$sub_exhibition."' WHERE userName = '".$userName."'";
	$db->query($update);
	return;
 }
 
 function removeUserExhibition($db, $exhibition_id){
	$userName = $_SESSION['userName'];
	$select = "SELECT * FROM member WHERE userName = '".$userName."'";
	$result = $db->query($select);
	$row = $result->fetch();

	if($row[4]){//有訂閱
	
		$temp = unserialize($row[4]);
		foreach($temp as $key => $value){
			if($value == $exhibition_id){
				unset($temp[$key]);
			}
		}
		$temp = array_values($temp);//重新排列index
		$sub_exhibition = serialize($temp);
		
	}else{//無訂閱
		return;
	}
		
	$update = "UPDATE member SET exhibition_subed = '".$sub_exhibition."' WHERE userName = '".$userName."'";
	$db->query($update);
	return;	
 }
?>