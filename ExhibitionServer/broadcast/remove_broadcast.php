<?php
 include "../db_pdo_conn.php";
 session_start();
 $title = $_POST['title'];
 $exhibition_id = ($_SESSION['exhibition_id'] != NULL) ? $_SESSION['exhibition_id'] : $_POST['id'];
 echo $title;
 echo $exhibition_id;
 /*
 $select = "SELECT image1, image2, image3 FROM broadcast where title = '".$title."' AND exhibition_id = '".$exhibition_id."'";
 $result = $db->query($select);
 while($row = $result->fetch()){
	for($i = 0;$i < 3;$i++){
		$dir = "../broadcastImage/";
		if(file_exists($dir.$row[$i]))
			unlink($dir.$row[$i]);//將檔案刪除
	} 
 }
 */
 $remove = "DELETE FROM broadcast where title = '".$title."' AND exhibition_id = '".$exhibition_id."'";
 $db->query($remove);
?>
