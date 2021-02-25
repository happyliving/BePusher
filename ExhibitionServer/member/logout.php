<?php
	include("../db_pdo_conn.php");
	session_start();
	$userName = $_SESSION['userName'];
	$password = $_SESSION['password'];
	$update = "UPDATE member SET status = 0 WHERE userName = '".$userName."' AND password = '".$password."'";
	$db->query($update);
	session_destroy();
?>