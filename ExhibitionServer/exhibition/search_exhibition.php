<?php
 include "../db_pdo_conn.php";
 
 class obj{
	var $exhibition_name;
	var $exhibition_id;
    var $length;
	var $width;
	var $height;
	var $introduce;
	var $mapImage;
	var $type;
	var $owner;
		 
	function obj($exhibition_name, $exhibition_id, $introduce, $length, $width, $height, $mapImage, $owner){
		$this->exhibition_name = $exhibition_name;
		$this->exhibition_id = $exhibition_id;
		$this->introduce = $introduce;
		$this->length = $length;
		$this->width = $width;
		$this->height = $height;
		$this->owner = $owner;
		$type = preg_split('/[.]/',$mapImage);
		$this->type = $type[1];
		$url = "../mapImage/".$mapImage;
		ob_start();  
		readfile($url);  
		$img = ob_get_contents();  
		ob_end_clean();  
		$this->mapImage = base64_encode($img);
		//$this->mapImage = $mapImage;
	}
 }
 
 if(isset($_POST['exhibition_name'])){
	$select = "SELECT * FROM exhibition WHERE exhibition_name like '%".$_POST['exhibition_name']."%'";
	$select_sql = $db->prepare($select); 
 }else{
	$select = "SELECT * FROM exhibition";
	$select_sql = $db->prepare($select);
 }
 $select_sql->execute();
 $result = $db->query($select);
 $row_total = $select_sql->rowCount();
 $objList = array();
 for($i = 0;$i < $row_total;$i++){
	$row = $result->fetch();
	$obj = new obj($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[8]);
	array_push($objList, $obj);	
 }
 echo json_encode($objList);
?>
