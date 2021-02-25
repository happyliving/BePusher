<?php
 include "../db_pdo_conn.php";
 
 /*
	收到圖片剪裁後存入本地端
	將展場資訊設成session暫存
 */
 
 
 session_start();
 $exhibition_name = $_POST['exhibition_name'];//展場名稱
 $exhibition_intro = $_POST['exhibition_intro'];//展場簡介
 $exhibition_id = generatorId();//隨機產生id
 $mapImage = $_FILES['mapImage']['name'];//抓取圖片檔名
 //$filename = iconv("utf-8", "big5", $mapImage);
 //$iconImage = $_FILES['iconImage']['name'];
 $mapImage = cutImage($mapImage, $exhibition_id);//裁圖
 $userName = $_SESSION['userName'];
 $version = -1;//圖片的版本
 
 $add_exhibition = "INSERT INTO exhibition VALUES('$exhibition_name','$exhibition_id','$exhibition_intro',0,0,0,'$mapImage','$mapImage','$userName','$version')";
 $db->query($add_exhibition);
 //$filename = iconv("utf-8", "big5", $mapImage);//轉成big5使其可寫入本地資料夾
 //move_uploaded_file($_FILES['mapImage']['tmp_name'],'../mapImage/'.$filename);//複製檔案
 //$filename = iconv("utf-8", "big5", $iconImage);//轉成big5使其可寫入本地資料夾
 //move_uploaded_file($_FILES['iconImage']['tmp_name'],'../iconImage/'.$filename);//複製檔案
 $_SESSION['exhibition_id'] = $exhibition_id;
 $_SESSION['exhibition_name'] = $exhibition_name;
 $_SESSION['mapImage'] = $mapImage;
 $_SESSION['exhibition_intro'] = $exhibition_intro;
 
 
 function generatorId(){
	 
    $id_len = 20;
    $id = '';
    // exit o,0,1,l
    $word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($word);
    for ($i = 0; $i < $id_len; $i++) {

        $id .= $word[rand() % $len];

    }
    return $id;
	
 }
 
 function cutImage($mapImage, $exhibition_id){
	/* 
	if($_SESSION['mapImage']){
		unlink($_SESSION['mapImage']);
	} 
	*/
	$type = preg_split('/[.]/',$mapImage);
	echo $type[1];
	if($type[1] == "png" || $type[1] == "PNG")
		$source = imageCreateFromPng($_FILES['mapImage']['tmp_name']);
	else
		$source = imageCreateFromJpeg($_FILES['mapImage']['tmp_name']);
	
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
	$x1 = $_POST['x1'];
	$x2 = $_POST['x2'];
	$y1 = $_POST['y1'];
	$y2 = $_POST['y2']; 
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

	$filename = iconv("utf-8", "big5", $mapImage);
	$path = '../mapImage/'.$exhibition_id.'_'.$filename;
	if($type[1] == "png" || $type[1] == "PNG")
		imagepng($crop,$path);
	else
		imagejpeg($crop,$path);
	$temp = $exhibition_id.'_'.$filename;
	return $temp;
 }
?>
