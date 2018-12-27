<?php	
	session_start();
	ob_start();

	include "../authentication.php";
	$auth = new auth;

	if(isset($_GET['action'])){
		switch(strip_tags($_GET['action'])){
			case "login": echo $auth->login($_POST['license']); break;
			case "login2": echo $auth->login2($_POST['username'], $_POST['email']); break;
			case "forgot": echo $auth->forgotLicense($_POST['email']); break;
		}
	}