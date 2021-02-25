<?php
	include "../db_pdo_conn.php";
	$exhibition_id = $_POST['id'];
	$select = "SELECT * FROM member";
	$select_sql = $db->prepare($select); 
    $select_sql->execute();
    $result = $db->query($select);
    $row_total = $select_sql->rowCount();
	
	for($i = 0 ; $i <= $row_total; $i++){
		$row = $result->fetch();
		if($row[4] != NULL){
			$temp = unserialize($row[4]);
			foreach($temp as $key => $value){
				if($value == $exhibition_id){
					unset($temp[$key]);
				}
			}
			$temp = array_values($temp);//重新排列index
			$sub_exhibition = serialize($temp);
			$update = "UPDATE member SET exhibition_subed = '".$sub_exhibition."' WHERE userName = '".$row[0]."'";
			$db->query($update);
		}
	}
	$delete_broadcast = "DELETE FROM broadcast WHERE exhibition_id = '".$exhibition_id."'";
	$db->query($delete_broadcast);
	
	$delete_beacon = "DELETE FROM beacon WHERE exhibition_id = '".$exhibition_id."'";
	$db->query($delete_beacon);
	
	$delete_sql = "DELETE FROM exhibition WHERE exhibition_id = '".$exhibition_id."'";
	$db->query($delete_sql);
	
	function checkId($exhibition_name, $db){
	$check = $db->query("SELECT exhibition_id FROM exhibition where exhibition_name = '".$exhibition_name."'");	
	$select_id = $check->fetch();
	if($select_id){
		return $select_id[0];
	}
	else{
		echo '<script>alert("此展場不存在");</script>';
		return; 
	}		
 }
?>