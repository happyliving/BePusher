<?php
	header("Access-Control-Allow-Origin: *");
	include "../db_pdo_conn.php";
	
	class obj{
		var $id;
		var $version;
		function obj($id, $version){
			$this->id = $id;
			$this->version = $version;
		}
	}
	
	$search = "SELECT exhibition_id, version FROM exhibition";
	$result = $db->query($search);
	$objList = array();
	while($row = $result->fetch()){
		$item = new obj($row[0], $row[1]);
		array_push($objList, $item);
	}
	echo json_encode($objList);
?>