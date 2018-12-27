 <?php
 
include('inc/database.php');

 if(isset($_GET['email']) && isset($_GET['token']))
 {
 	$email = $con->real_escape_string($_GET['email']);
 	$token = $con->real_escape_string($_GET['token']);

 	$SQLquery = $con->query("SELECT `id` FROM `users` WHERE `email` = '$email' AND `token` = '$token'");

 	if($SQLquery->num_rows == 0 || $SQLquery->num_rows < 1)
 	{
 		echo '
 		
 			<div class="alert alert-danger">
  <strong>ERROR!</strong> Please verify that you have the correct URL given in your email
						</div>
 		
 		';
 	}
 	else if($SQLquery->num_rows > 0)
 	{
 		$generate_password = "Mypassword1";

 		$new_password = mysqli_real_escape_string($con, $_POST['password']);
        $hashed_password = password_hash($generate_password, PASSWORD_DEFAULT);
 		if($con == true)
 		{
 			$con->query("UPDATE `users` SET `password` = '$hashed_password', `token` = '' WHERE `email` = '$email'");

 			echo '
 			
 				<div class="alert alert-success">
  <strong>Success!</strong> Your new password is: <strong>' . $generate_password . '</strong><strong> Reset This Immediatly From Your Profile.</strong> contact staff if needed!
						</div>
 			';
 		}
 		else
 		{
 			echo 'Not connected to the database';
 			die();
 		}
 	}
 }else
 {
 header('location: login.php');
 die();
 }


 ?>
 
 <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Description" content="MvGenerator 2.0, We have two types of generators, Free & Paid this gives you a chance to get some free accounts before moving to our paid generator " >
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo $favicon;?>">
<script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Page title -->
    <title>Reset Password</title>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>

    <!-- App styles -->
    <link rel="stylesheet" href="styles/pe-icons/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="styles/pe-icons/helper.css"/>
    <link rel="stylesheet" href="styles/stroke-icons/style.css"/>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="blank">

<!-- Wrapper-->
<div class="wrapper">

    <!-- Main content-->
    <section class="content">


        <div class="container-center animated slideInDown">
<center>
	<a class="btn btn-primary btn-block" href="login.php">Login Now</a>
</center>

</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="vendor/pacejs/pace.min.js"></script>
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- App scripts -->
<script src="scripts/luna.js"></script>
<SCRIPT LANGUAGE="JavaScript">

function ClipBoard()
{
alert("copied");
window.clipboardData.setData("Text",document.links.txtbox1);
}
</SCRIPT>
</body>

</html>