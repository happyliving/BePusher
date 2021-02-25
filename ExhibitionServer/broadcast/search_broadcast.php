<?php
	//給展場id, 回傳推播
	header("Access-Control-Allow-Origin: *");
	include "../db_pdo_conn.php";
	class broadcastObj{
		var $title;
		var $info;
		var $vendorId;
		var $broadcastImage1;
		var $broadcastImage2;
		var $broadcastImage3;
		var $url;
		var $fb_url;
		var $twitter_url;
		var $type1;
		var $type2;
		var $type3;
		var $x;
		var $y;
		var $z;
			 
		function broadcastObj($title, $info, $vendorId, $broadcastImage1, $broadcastImage2, $broadcastImage3, $url, $fb_url, $twitter_url, $x, $y, $z){
			$this->title = $title;
			$this->info = $info;
			$this->vendorId = $vendorId;
			$this->x = $x;
			$this->y = $y;
			$this->z = $z;
			$this->url = $url;
			$this->fb_url = $fb_url;
			$this->twitter_url = $twitter_url;
			
			
			$type = preg_split('/[.]/',$broadcastImage1);
			$this->type1 = $type[1];
			
			$url = "../broadcastImage/".$broadcastImage1;
			ob_start();  
			readfile($url);  
			$img1 = ob_get_contents();  
			ob_end_clean();  
			$this->broadcastImage1 = base64_encode($img1);
			
			//
			$type = preg_split('/[.]/',$broadcastImage2);
			$this->type2 = $type[1];
			$url = "../broadcastImage/".$broadcastImage2;
			ob_start();  
			readfile($url);  
			$img2 = ob_get_contents();  
			ob_end_clean();  
			$this->broadcastImage2 = base64_encode($img2);
			
			//
			$type = preg_split('/[.]/',$broadcastImage3);
			$this->type3 = $type[1];
			$url = "../broadcastImage/".$broadcastImage3;
			ob_start();  
			readfile($url);  
			$img3 = ob_get_contents();  
			ob_end_clean();  
			$this->broadcastImage3 = base64_encode($img3);
			
		}
	}
	$exhibition_id = $_POST['id'];
	$select = "SELECT * FROM broadcast WHERE exhibition_id = '".$exhibition_id."'";
	$select_sql = $db->prepare($select); 
	$select_sql->execute();
	$result = $db->query($select);
	$row_total = $select_sql->rowCount();
	$objList = array();
	for($i = 0;$i < $row_total;$i++){
		$row = $result->fetch();
		$broadcastObj = new broadcastObj($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
		array_push($objList, $broadcastObj);	
	}
	echo json_encode($objList);
?>