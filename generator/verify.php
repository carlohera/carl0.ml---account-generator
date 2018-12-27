		<!doctype html>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/92209a86/cloudflare-static/rocket-loader.min.js" data-cf-nonce="1f6d61e5fb50aaf454cd77d5-"></script>
<html lang="en-US" oncontextmenu="return false;" onkeydown="return false;" onmousedown="return false;">
<head>
<meta charset="UTF-8">
<meta name="classification" content="Digi Tools Email Verification" />
<meta name="keyword" content="Digi Tools Email Verification" />
<meta name="description" content="Digi Tools Email Verification" />
<meta name="googlebot" content="index,follow" />
<meta name="robots" content="all" />
<meta name="robots schedule" content="auto" />
<meta name="distribution" content="global" />
<meta name="Author" content="Cryptic Hunter">
<title>Digi Tools Email Verification</title>
<meta http-equiv="imagetoolbar" content="no">
<link rel="SHORTCUT ICON" href="https://upload.wikimedia.org/wikipedia/en/7/7b/DePauw_Tigers_logo.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="https://fonts.googleapis.com/css?family=Iceland" rel="stylesheet">
</head>
<body>
<style>
	body{
		background: url(https://i.imgur.com/RkVKeui.jpg) no-repeat center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	.title {
		font-family: Iceland;
		color: white;
		font-size: 50px;
		text-shadow: 0px 0px 15px #00ff00;
	}
	.team {
		font-family: Iceland;
		color: white;
		font-size: 35px;
		text-shadow: 0px 0px 15px red;
	}
	footer {
		position: fixed;
		bottom: 10px;
		text-align: center;
	}
</style>

<center><span class="team">	<?php

include "inc/database.php";


if (isset($_GET['email']) && isset($_GET['hash'])){
    $email = mysqli_real_escape_string($con, $_GET['email']);
    $hash = mysqli_real_escape_string($con, $_GET['hash']);
	
	$search = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email' AND `hash` = '$hash'") or die(mysqli_error($con));
    $match  = mysqli_num_rows($search);
	
	if($match > 0)
	{
        mysqli_query($con, "UPDATE `users` SET `active` = '1' WHERE `email` = '$email' AND `hash` = '$hash'") or die(mysqli_error($con));
	echo '<div class="alert alert-success alert-colored"><center><strong>Your Account Has Been Activated</strong></center></div>';
    }
	else
	{
	echo '<div class="alert alert-danger alert-colored">
  <center><strong>ERROR!</strong></center> <br> <center><strong>Invalid approach</strong></center> <br> <center><strong>Please Use The Link That Has Been Sent To Your Email</strong></center>
						</div>';
    }
                 
}
else
{
	echo '<div class="alert alert-danger alert-colored">
  <center><strong>ERROR!</strong></center> <br> <center><strong>The URL Is Either Invalid Or You Already Have Activated Your Account</strong></center>
						</div>';
}

?>
						</div>
			
                            <div class="form-group">
                                <div class="form-group">
									<a class="btn btn-primary btn-block w-md waves-effect waves-light" href="login.php"><i class="fa fa-user"></i> Login</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div></span></center>

</html>

	