<?php
	include('func.mysqli.php');
	session_start();
	$user_check = $_SESSION['cctmuser'];
	 
	$sql = mysqli_query($db,"SELECT * FROM users WHERE smallname='$user_check' ");
	 
	$row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
	 
	$login_user = $row['smallname'];
	 
	if(!isset($user_check)) {
	header("Location: login.php");
	}
?>