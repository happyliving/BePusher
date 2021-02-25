<?php
 include "../db_pdo_conn.php";
 
 $exhibition_name = $_POST['exhibition_name'];
 removeImage($exhibition_name."_map.jpg", "map");
 removeImage($exhibition_name."_icon.jpg", "icon");
 $remove = "DELETE FROM exhibition where exhibition_name = '$exhibition_name'";
 $db->query($remove);
 echo '<script>alert("刪除成功");</script>';
 echo '<script>window.location.href = "exhibition.php";</script>';
 
 
 function removeImage($filename,$type) {  
	$filename = iconv("utf-8", "big5", $filename);//轉成big5使其可寫入本地資料夾
	if($type == "map"){
		unlink("../mapImage/".$filename);
	}
	else{//type=="icon"
		unlink("../iconImage/".$filename);
	}
	return;  
 }  
 
?>
