<?php

ob_start();

include 'inc/database.php';

function sec_tag($connection, $element){
    $filter_tag = htmlspecialchars(stripcslashes(mysqli_real_escape_string($connection, $element)));
	return $filter_tag;
}

$result = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
	$website = $row['website'];
	$favicon = $row['favicon'];
}

if (!isset($_SESSION)) { 
	session_start(); 
}

if (isset($_SESSION['username'])) {

}

if(isset($_GET['username']) && isset($_GET['password'])){

	$username = sec_tag($con, $_GET['username']);
	$password = sec_tag($con, md5($_GET['password']));
	
	$result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error($con));
	$ip = sec_tag($con, $_SERVER['REMOTE_ADDR']);
	mysqli_query($con, "INSERT INTO `login_logs` (`username`, `ip`) VALUES ('$username', '$ip')") or die(mysqli_error($con));
	if(mysqli_num_rows($result) < 1){
		die("Inorrect Details");
	}
	while($row = mysqli_fetch_array($result)){
		if($password != $row['password']){
			die("Incorrect Password");
		}elseif($row['status'] == "0"){
			die("You Have Been Banned");
		}else{
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $row['email'];
			$_SESSION['rank'] = $row['rank'];
			die("Successfully Logged In");
		}
	}
	
}




?>