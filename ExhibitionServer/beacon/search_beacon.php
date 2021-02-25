<?php

 /*
    回傳展場內的beaconArray
 */

 include "../db_pdo_conn.php";
 session_start();
 class obj{
	var $beacon_name;
	var $major;
    var $minor;
	var $beacon_positionX;
	var $beacon_positionY;
	var $beacon_positionZ;
	var $exhibition_id;
		 
	function obj($beacon_name, $major, $minor, $beacon_positionX, $beacon_positionY, $beacon_positionZ, $exhibition_id){
		$this->beacon_name = $beacon_name;
		$this->major = $major;
		$this->minor = $minor;
		$this->beacon_positionX = $beacon_positionX;
		$this->beacon_positionY = $beacon_positionY;
		$this->beacon_positionZ = $beacon_positionX;
		$this->exhibition_id = $exhibition_id;
	}
 }
 
 $exhibition_id = $_POST['id'];
 $select = "SELECT * FROM beacon WHERE exhibition_id = '".$exhibition_id."'";
 $select_sql = $db->prepare($select); 
 $select_sql->execute();
 $result = $db->query($select);
 $row_total = $select_sql->rowCount();
 $objList = array();
 for($i = 0;$i < $row_total;$i++){
	$row = $result->fetch();
	$obj = new obj($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
	array_push($objList, $obj);	
 }
 //storeUserExhibition($db, $exhibition_id);
 echo json_encode($objList);
 
 /*
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
 */
 
?>