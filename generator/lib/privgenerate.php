<?php

$maxuse = 1;

$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($pos===false){
  die('No Access');
}



include '../inc/database.php';
$generator = mysqli_real_escape_string($con, $_GET['id']);
$generator_name = mysqli_real_escape_string($con, $_GET['name']);
$username = mysqli_real_escape_string($con, $_SESSION['username']);


$result = mysqli_query($con, "SELECT * FROM `privgenerators` WHERE `id` = '$generator'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
	$gen_max = $row['max'];
}



$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
	$package = $row['package'];
}

$result = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$package'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
	$accounts = $row['accounts'];
}

$date = date("Y-m-d");

if($accounts != "0" && $accounts != "" && $_SESSION['rank'] != "5"){
	$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
	while($row = mysqli_fetch_assoc($result)){
		if($row['generated'] >= $accounts){

			exit("Generated Maximum Daily Accs");
		}
	}
}
if(true){

	$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username' AND `date` = '$date' AND `gen` = '$generator'") or die(mysqli_error($con));
	while($row = mysqli_fetch_assoc($result)){
		if($row['generated'] >= $gen_max){
			exit("Generated Maximum Private Accs");
		}
	}
}

$result = mysqli_query($con, "SELECT * FROM `privgenerator$generator` WHERE `status` != '0' AND `uses` < $maxuse ORDER BY RAND() LIMIT 1") or die(mysqli_error($con));
if(mysqli_num_rows($result) < 1){
	exit("Out of Stock");
}
while($row = mysqli_fetch_array($result)){
	echo $row['alt'];
        $acc = $row['alt'];
        $id = $row['id'];
        $cnt = $row['uses']+1;
        mysqli_query($con, "UPDATE `privgenerator$generator` SET `uses` = '$cnt' WHERE `id` = '$id'") or die(mysqli_error($con));
}

$date = date("Y-m-d");
$ip = $_SERVER['REMOTE_ADDR'];

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username' AND `date` = '$date' AND `gen` = '$generator'") or die(mysqli_error($con));
if(mysqli_num_rows($result) == "0"){
	mysqli_query($con, "INSERT INTO `privstatistics` (`username`, `generated`, `date`, `gen`) VALUES ('$username', '1', DATE('$date'), '$generator')") or die(mysqli_error($con));
}else{
	while($row = mysqli_fetch_array($result)){
		$generated = $row['generated'] + "1";
		mysqli_query($con, "UPDATE `privstatistics` SET `generated` = '$generated' WHERE `username` = '$username' AND `date` = '$date' AND `gen` = '$generator'") or die(mysqli_error($con));
	}
}

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
if(mysqli_num_rows($result) == "0"){
	mysqli_query($con, "INSERT INTO `privstatistics` (`username`, `generated`, `date`) VALUES ('$username', '1', DATE('$date'))") or die(mysqli_error($con));
}else{
	while($row = mysqli_fetch_array($result)){
		$generated = $row['generated'] + "1";
		mysqli_query($con, "UPDATE `privstatistics` SET `generated` = '$generated' WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
	}
}
mysqli_query($con, "INSERT INTO `statistics_det` (`gen`, `username`, `account`, `ip`) VALUES ('$generator_name', '$username', '$acc', '$ip')") or die(mysqli_error($con));
?>