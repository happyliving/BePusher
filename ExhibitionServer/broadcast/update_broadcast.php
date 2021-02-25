<?php
 //給展場id,推播內容進行修改
 include "../db_pdo_conn.php";
 $exhibition_id = $_POST['exhibition_id'];
 $broadcastArray = $_POST['broadcastArray'];
 //$exhibition_id = 'ELyzaL2R4jwtiTOLuJsl';
 $old_title = 'title';
 $select = "SELECT * FROM broadcast WHERE exhibition_id = '".$exhibition_id."' AND title = '".$old_title."'";
 $oldBroadcast = $db->query($select);
 
 
 foreach($broadcastArray as $broadcast){
	$title = $broadcast['title'];
	$info = $broadcast['info'];
	$broadcast_positionX = $broadcast['x'];
	$broadcast_positionY = $broadcast['y'];
	$broadcast_positionZ = $broadcast['z'];
	$vendorId = $broadcast['vendorId'];
	$url = $broadcast['url'];
	$fb_url = $broadcast['fb_url'];
	$twitter_url = $broadcast['twitter_url'];
	$broadcastImage1 = $_FILES['img1']['name'];
	$broadcastImage2 = $_FILES['img2']['name'];
	$broadcastImage3 = $_FILES['img3']['name'];
 
	storeImage($broadcastImage1);
	storeImage($broadcastImage2);
	storeImage($broadcastImage3);
	
	$update = "UPDATE broadcast 
			SET	title = '".$title."' AND
				info = '".$info."' AND
				vendorID = '".$vendorId."' AND
				image1 = '".$broadcastImage1."' AND
				image2 = '".$broadcastImage2."' AND
				image3 = '".$broadcastImage3."' AND
				url = '".$url."' AND
				fb_url = '".$fb_url."' AND
				twitter_url = '".$twitter_url."' AND
				broadcast_positionX = '".$broadcast_positionX."' AND
				broadcast_positionX = '".$broadcast_positionY."' AND
				broadcast_positionX = '".$broadcast_positionZ."'
			WHERE exhibition_id = '".$exhibition_id."'";
	$db->query($update);
	
 }

 /*
 while($row = $oldBroadcast->fetch()){
	 
	 $title = (isset($_POST['title'])) ? $_POST['title'] : $row[0];
	 $info = (isset($_POST['info'])) ? $_POST['info'] : $row[1];
	 $vendorId = (isset($_POST['vendorID'])) ? $_POST['vendorID'] : $row[2];
	 
	 if(isset($_FILES['broadcastImage1'])){
		 $broadcastImage1 = $_FILES['broadcastImage1']['name'];
		 storeImage($broadcastImage1);
	 }else{
		 $broadcastImage1 = $row[3];
	 }
	 
	 if(isset($_FILES['broadcastImage2'])){
		 $broadcastImage2 = $_FILES['broadcastImage2']['name'];
		 storeImage($broadcastImage2);
	 }else{
		 $broadcastImage2 = $row[4];
	 }
	 
	 if(isset($_FILES['broadcastImage3'])){
		 $broadcastImage3 = $_FILES['broadcastImage3']['name'];
		 storeImage($broadcastImage3);
	 }else{
		 $broadcastImage3 = $row[5];
	 }
	 
	 $url = (isset($_POST['url'])) ? $_POST['url'] : $row[6];
	 $fb_url = (isset($_POST['fb_url'])) ? $_POST['fb_url'] : $row[7];
	 $twitter_url = (isset($_POST['twitter_url'])) ? $_POST['twitter_url'] : $row[8];
	 $broadcast_positionX = (isset($_POST['posX'])) ? $_POST['posX'] : $row[9];
	 $broadcast_positionY = (isset($_POST['posY'])) ? $_POST['posY'] : $row[10];
	 $broadcast_positionZ = (isset($_POST['posZ'])) ? $_POST['posZ'] : $row[11];
 }
 */
 
 
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
 
 function storeImage($broadcastImage){
	
	$type = preg_split('/[.]/',$broadcastImage);
	echo $type[1];
	if($type[1] == "png" || $type[1] == "PNG")
		$source = imageCreateFromPng($_FILES['broadcastImage']['tmp_name']);
	else
		$source = imageCreateFromJpeg($_FILES['broadcastImage']['tmp_name']);
	
	if (!$source){
		echo "error";
		// 圖片開啟錯誤...
		return;
	}


	// 取得圖片原始寬度與高度
	$sourceWidth  = imagesx($source);
	$sourceHeight = imagesy($source);


	/* 裁切圖片 */
	// 圖片選取的寬度與高度
	$x1 = 0;//$x1 = $_POST['x1'];
	$x2 = 100;//$x2 = $_POST['x2'];
	$y1 = 0;//$y1 = $_POST['y1'];
	$y2 = 100;//$y2 = $_POST['y2']; 
	$cropWidth = $x2 - $x1; 
	$cropHeight = $y2 - $y1;

	
	// 檢查裁切寬度是否在範圍裡
	if (!$cropWidth || $cropWidth > $sourceWidth){ // 寬度為零或超過最大寬度
		$cropWidth = $sourceWidth; 
	}

	// 檢查裁切高度是否在範圍裡
	if (!$cropHeight || $cropHeight > $sourceHeight){ // 高度為零或超過最大高度
		$cropHeight = $sourceHeight;
	}


	// 圖片選取的起始位址
	$cropX = $x1;
	$cropY = $y1;

	// 檢查起始位址
	if ($cropX > ($sourceWidth-$cropWidth)){
		$cropX = $sourceWidth-$cropWidth; 
	}
	if ($cropY > ($sourceHeight-$cropHeight)){
		$cropY = $sourceHeight-$cropHeight;
	}


	// 建立裁切所需要的圖片空間
	$crop = imageCreateTrueColor($cropWidth, $cropHeight);

	// 複製選定的圖片範圍(剪裁圖片)
	imagecopy(
		$crop, 
		$source, 
		0, 
		0,
		$cropX, 
		$cropY, 
		$cropWidth, 
		$cropHeight
	);

	$filename = iconv("utf-8", "big5", $broadcastImage);
	$path = '../broadcastImage/'.$filename;
	if($type[1] == "png" || $type[1] == "PNG")
		imagepng($crop,$path);
	else
		imagejpeg($crop,$path);
 }
 

?>
