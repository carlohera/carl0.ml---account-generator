<?php
	include "../../includes.php";
	$con = new database;
	$con->connect();

	if(!isset($_SESSION['time'])){
		$_SESSION['time'] = time()+3;
	}
	
	if(isset($_GET['action'])){
		switch(strip_tags($_GET['action'])){
			case "get": echo $user->getShoutboxShouts(); break;
			case "shout": echo $user->sendShout($_POST['message']); break;
			case "getLogs": $user->getLatestMenuLogins(); break;
			case "gen":
				$license = $user->generateRandomString()."-".$user->generateRandomString()."-".$user->generateRandomString()."-".$user->generateRandomString();
				echo json_encode(array("license"=>$license )); break;
		}
	}