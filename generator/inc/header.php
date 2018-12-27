<?php

ob_start();

include 'inc/database.php';

if (!isset($_SESSION)) { 
	session_start(); 
}

function sec_tag($connection, $element){
	$filter_tag = htmlspecialchars(stripcslashes(mysqli_real_escape_string($connection, $element)));
	return $filter_tag;
}

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

$username = $_SESSION['username'];
$id = $_SESSION['id'];
$date = date("Y-m-d");
$datetime = date("Y-m-d H:i:s");

$result = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
	$website = $row['website'];
	$paypal = $row['paypal'];
	$footer = $row['footer'];
	$favicon = $row['favicon'];
}

$generated = 0;

$result = mysqli_query($con, "SELECT * FROM `statistics`") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$generated = $generated + $row['generated'];
}



$result = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '$id'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$profile_img = $row['profile_img'];
	$level = $row['level'];
	$email = $row['email'];
	$firstandlastnamekek = $row['first_last_name'];
	$bio = $row['bio'];
	$cover_pic = $row['cover_pic'];
}

?>