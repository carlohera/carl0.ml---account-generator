<?php
	if(!isset($_SESSION["captcha"])) {
		$num1 = rand(0,9);
		$num2 = rand(0,9);
		$captcha = $num1 + $num2;
		$_SESSION["captcha"] = $captcha;
		$_SESSION["num1"] = $num1;
		$_SESSION["num2"] = $num2;
	}
	
	function newCaptcha() {
		unset($_SESSION["num1"], $_SESSION["num2"], $_SESSION["captcha"]);
	}
	
	function getNumbers() {
		echo($_SESSION["num1"]." + ".$_SESSION["num2"]." = ?");
	}