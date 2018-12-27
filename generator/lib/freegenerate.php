<?php

$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($pos===false){
  die('No Access');
}

include '../inc/database.php';

$generator = mysqli_real_escape_string($con, $_GET['id']);
$generator_name = mysqli_real_escape_string($con, $_GET['name']);
$username = mysqli_real_escape_string($con, $_GET['username']);

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
	$package = $row['package'];
}

$result = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$package'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
	$accounts = $row['accounts'];
}

$date = date("Y-m-d");

if($accounts != "0" && $accounts != "" && $_SESSION['rank'] != "4"){
	$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
	while($row = mysqli_fetch_assoc($result)){
		if($row['generated'] >= $accounts){
			exit("Generated max per day");
		}
	}
}

$result = mysqli_query($con, "SELECT * FROM `freegenerator0` WHERE `status` != '0' ORDER BY RAND() LIMIT 1") or die(mysqli_error($con));
if(mysqli_num_rows($result) < 1){
	exit("0 Accounts in stock");
}
while($row = mysqli_fetch_array($result)){
	echo $row['alt'];
	$acc = $row['alt'];
}

$date = date("Y-m-d");

$result = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
if(mysqli_num_rows($result) == "0"){
	mysqli_query($con, "INSERT INTO `freestatistics` (`username`, `generated`, `date`) VALUES ('$username', '1', DATE('$date'))") or die(mysqli_error($con));
}else{
	while($row = mysqli_fetch_array($result)){
		$generated = $row['generated'] + "1";
		mysqli_query($con, "UPDATE `freestatistics` SET `generated` = '$generated' WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
	}
}

$date = date("Y-m-d");
$ip = $_SERVER['REMOTE_ADDR'];

mysqli_query($con, "INSERT INTO `freegen_history` (`gen`, `username`, `account`, `ip`) VALUES ('$generator_name', '$username', '$acc', '$ip')") or die(mysqli_error($con));
?>