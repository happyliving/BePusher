<?php
 include "db_pdo_conn.php";
 
 /*
 將展場、beacon、推播新增至資料庫
 */
 
 //update exhibition data
 session_start();
 $exhibition_name = $_SESSION['exhibition_name'];
 $exhibition_id = $_SESSION['exhibition_id'];
 $length = $_POST['length'];
 $width = $_POST['width'];
 $height = $_POST['height'];
 $intro = $_SESSION['exhibition_intro'];
 $mapImage = $_SESSION['mapImage'];
 $iconImage = $_SESSION['mapImage'];
 $userName = $_SESSION['userName'];
 $search = "SELECT version FROM exhibition WHERE exhibition_id = '$exhibition_id'";
 $result = $db->query($search);
 while($row = $result->fetch()){
	 $version = $row[0];
 }
 $version++;
 //$filename = iconv("utf-8", "big5", $mapImage);//轉成big5使其可寫入本地資料夾
 //move_uploaded_file($_FILES['mapImage']['tmp_name'],'mapImage/'.$filename);//複製檔案
 //$filename = iconv("utf-8", "big5", $iconImage);//轉成big5使其可寫入本地資料夾
 //move_uploaded_file($_FILES['iconImage']['tmp_name'],'iconImage/'.$filename);//複製檔案
 $add_exhibition = "UPDATE exhibition SET length='$length', width='$width', height='$height' , version='$version' WHERE exhibition_id='$exhibition_id'";
 $db->query($add_exhibition);
 
 
 //add beacon
 $beaconArray = $_POST['beaconArray'];
 foreach($beaconArray as $beacon){
	 $beacon_name = $beacon['name'];
	 $major = $beacon['major'];
	 $minor = $beacon['minor'];
	 $positionX = $beacon['x'];
	 $positionY = $beacon['y'];
	 $positionZ = $beacon['z'];
	 $add_beacon = "INSERT INTO beacon VALUES('$beacon_name','$major','$minor','$positionX','$positionY','$positionZ','$exhibition_id')";
	 $db->query($add_beacon);
 }
	//echo '<script>alert("新增成功");</script>';
 
 
 
 /*
 $broadcastArray = $_POST['broadcastArray'];
 echo $broadcastArray;
 //add broadcast
 
 foreach($broadcastArray as $broadcast){
	$title = $broadcast['title'];
	$info = $broadcast['info'];
	$broadcast_positionX = $broadcast['x'];
	$broadcast_positionY = $broadcast['y'];
	$broadcast_positionZ = $broadcast['z'];
	$vendorId = $_POST['vendorId'];
	$url = $_POST['url'];
	$fb_url = $_POST['fb_url'];
	$twitter_url = $_POST['twitter_url'];
	$exhibition_id = $_SESSION['exhibition_id'];
	$broadcastImage1 = $_FILES['img1']['name'];
	$broadcastImage2 = $_FILES['img2']['name'];
	$broadcastImage3 = $_FILES['img3']['name'];
 
	storeImage($broadcastImage1);
	storeImage($broadcastImage2);
	storeImage($broadcastImage3);
	$add = "INSERT INTO broadcast VALUES('$title','$info','$vendorId','$broadcastImage1','$broadcastImage2','$broadcastImage3','$url','fb_url','twitter_url,'$broadcast_positionX','$broadcast_positionY','$broadcast_positionZ','$exhibition_id')";
	$db->query($add);
 }
 */
 
 //清空此筆展場的session
 unset($_SESSION['exhibition_name']);
 unset($_SESSION['exhibition_id']);
 unset($_SESSION['exhibition_intro']);
 unset($_SESSION['mapImage']);
 //unset($_SESSION['iconImage']);
 //session_destroy();
 
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