<?php
	session_start();
	ob_start();
	include "php/user.php";
	$user = new user;
?>