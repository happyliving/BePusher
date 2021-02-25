<?php
 include "../db_pdo_conn.php";
 
 $beacon_name = $_POST['beacon_name'];
 $remove = "DELETE FROM beacon where beacon_name = '$beacon_name'";
 $db->query($remove);
 echo '<script>alert("刪除成功");</script>';
 //echo '<script>window.location.href = "beacon.php";</script>';
 
?>
