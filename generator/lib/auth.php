<?php
	include "../inc/database.php";
	private function login()
	{
	    $username = htmlspecialchars($_POST['usernameoremail']);
    	$password = htmlspecialchars($_POST['password']);
    	$passwordhashed = password_hash($password, PASSWORD_BCRYPT);
    	
        $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' OR `email` = '$username'") or die(mysqli_error($con));
    	
        $ip = $_SERVER['REMOTE_ADDR'];
        mysqli_query($con, "INSERT INTO `login_logs` (`username`, `ip`) VALUES ('$username', '$ip')") or die(mysqli_error($con));
        if(mysqli_num_rows($result) < 1)
    	{
           // header("Location: /Login/?error=no-exist");
            return "no-exist";
        }
        while($row = mysqli_fetch_array($result))
    	{
    		if(password_verify($password,$row['password']))
    		{
    			if($row['status'] == "0")
    			{
    			;;	header("Location: /Login/?error=banned");
    				return "banned";
    			}
    			else
    			{
    				$_SESSION['id'] = $row['id'];
    				$id = $_SESSION['id'];
    				$_SESSION['username'] = $row['username'];
    				$_SESSION['email'] = $row['email'];
    				$_SESSION['rank'] = $row['rank'];
    				$ip = $_SERVER['REMOTE_ADDR'];
    				mysqli_query($con, "UPDATE `users` SET `ip` = '$ip' WHERE `id` = '$id'") or die(mysqli_error($con));
    				return "success";
    			}
    		}		
    		else
    		{
               // header("Location: /Login/?error=incorrect-password");
               return "incorrect-password";
    		}	
        }
        return "error";
	}
	
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case "login": echo login($_POST['usernameoremail'], $_POST['password']); break;
		}
	}