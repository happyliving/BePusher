<?php
 header("Access-Control-Allow-Origin: *");
 include "../db_pdo_conn.php";
 session_start();
 $title = $_POST['title'];
 $info = $_POST['info'];
 $broadcast_positionX = $_POST['x'];
 $broadcast_positionY = $_POST['y'];
 $broadcast_positionZ = $_POST['z'];
 $vendorId = $_POST['vendorId'];
 $url = (isset($_POST['url'])) ? $_POST['url'] : null;
 $fb_url = (isset($_POST['fb_url'])) ? $_POST['fb_url'] : null;
 $twitter_url = (isset($_POST['twitter_url'])) ? $_POST['twitter_url'] : null;
 //$exhibition_id = "ELyzaL2R4jwtiTOLuJsl";
 $exhibition_id = ($_SESSION['exhibition_id'] != NULL) ? $_SESSION['exhibition_id'] : $_POST['id'];
 
 $imgSize = $_POST['imageSize'];//imgSize = 1 to 3
 $broadcastImage = Array(3);
 
 for($i = 0; $i < 3; $i++)//initialize broadcast array
	$broadcastImage[$i] = "fake".($i+1).".png";

 for($i = 0; $i < $imgSize; $i++){	
	 $broadcastImage[$i] = $_FILES['file-'.$i]['name'];
	 storeImage($broadcastImage[$i], $i);
 }
 $img1 = $broadcastImage[0];
 $img2 = $broadcastImage[1];
 $img3 = $broadcastImage[2];

 //PK有問題
 //$exhibition_id = checkId($exhibition_name, $db);
 $add = "INSERT INTO broadcast VALUES('$title','$info','$vendorId','$img1','$img2','$img3','$url','fb_url','twitter_url','$broadcast_positionX','$broadcast_positionY','$broadcast_positionZ','$exhibition_id')";
 $db->query($add);
 //echo '<script>alert("新增成功");</script>';
 //echo '<script>window.location.href = "broadcast.php";</script>';
 
 
 
 function checkId($exhibition_name, $db){
	$check = $db->query("SELECT exhibition_id FROM exhibition where exhibition_name = '$exhibition_name'");	
	$select_id = $check->fetch();
	if($select_id){
		return $select_id[0];
	}
	else{
		echo '<script>alert("此展場不存在");</script>';
		//echo '<script>window.location.href = "broadcast.php";</script>';
		return; 
	}		
 }
 
 function storeImage($broadcastImage, $index){
	$type = preg_split('/[.]/',$broadcastImage);
	if($type[1] == "png" || $type[1] == "PNG")
		$source = imageCreateFromPng($_FILES['file-'.$index]['tmp_name']);
	else
		$source = imageCreateFromJpeg($_FILES['file-'.$index]['tmp_name']);
	
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
