<?php

include "inc/header.php";

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
if (mysqli_num_rows($result) < 1 && $_SESSION['rank'] != "5") {
	$expires = 'No Package';
}
if($_SESSION['rank'] == "5"){
	$expires = "Lifetime";
}else{
	while($row = mysqli_fetch_assoc($result)) {
		$expires = "Untill ".$row["expires"];
	}
}
error_reporting(0);
$totalalts = 0;

$result = mysqli_query($con, "SELECT * FROM `generators`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$result2 = mysqli_query($con, "SELECT * FROM `generator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
	$totalalts = $totalalts + mysqli_num_rows($result2);
}

$result = mysqli_query($con, "SELECT * FROM `users`") or die(mysqli_error($con));
$totalusers = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `status` = '1'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
		$email = $row["email"];
		$password = $row['password'];
		$user_id = $row["id"];
		$first_last_name = $row["first_last_name"];
}
$pageon = "Profile";

$uid = (isset($_GET['uid'])) ? $_GET['uid'] : $_SESSION['uid'];

$query = "SELECT * FROM users WHERE id = $uid";

$generatestotal = 0;

$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestotal = $generatestotal + $row['generated'];
	
	$totalalts = 0;

$result = mysqli_query($con, "SELECT * FROM `generators`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$result2 = mysqli_query($con, "SELECT * FROM `generator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
	$totalalts = $totalalts + mysqli_num_rows($result2);
}

$generatestotal = 0;

$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestotal = $generatestotal + $row['generated'];
}

$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestoday = $row['generated'];
}
}

$privgeneratestotal = 0;

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$privgeneratestotal = $privgeneratestotal + $row['generated'];
}

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$privgeneratestoday = $row['generated'];
}

$totalalts = 0;
$result = mysqli_query($con, "SELECT * FROM `generators`") or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result)) {
	$result2 = mysqli_query($con, "SELECT * FROM `generator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
	$totalalts = $totalalts + mysqli_num_rows($result2);
}
$result = mysqli_query($con, "SELECT * FROM `freegenerators`") or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result)) {
    $result2 = mysqli_query($con, "SELECT * FROM `freegenerator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
    $totalfree = $totalfree + mysqli_num_rows($result2);
}

$totalfreenpaid = $totalalts + $totalfree + $privtotalalts;
$result = mysqli_query($con, "SELECT * FROM `users`") or die(mysqli_error($con));
$totalusers = mysqli_num_rows($result);

if (isset($_GET['delete'])){
	$id = mysqli_real_escape_string($con, $_GET['delete']);
	mysqli_query($con, "DELETE FROM `news` WHERE `id` = '$id'") or die(mysqli_error($con));

	echo '
		<script>
			window.history.replaceState("object or string", "Title", "index.php");
		</script>
	';
}
if (isset($_POST['addnews'])){
    $title = mysqli_real_escape_string($con, $_POST['addtitle']);
	$message = mysqli_real_escape_string($con, $_POST['addnews']);
    $colourp = mysqli_real_escape_string($con, $_POST['coloured']);
	mysqli_query($con, "INSERT INTO `news` (`title`, `message`, `writer`, `date`, `colour`) VALUES ('$title', '$message', '$_SESSION[username]', '$datetime', '$colourp')") or die(mysqli_error($con));
}

if (isset($_POST['newsid']) && isset($_POST['editmessage'])){
	$id = mysqli_real_escape_string($con, $_POST['newsid']);
	$title = mysqli_real_escape_string($con, $_POST['edittitle']);
	$message = mysqli_real_escape_string($con, $_POST['editmessage']);
	mysqli_query($con, "UPDATE `news` SET `message` = '$message' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `news` SET `title` = '$title' WHERE `id` = '$id'") or die(mysqli_error($con));

}
$result = mysqli_query($con, "SELECT * FROM `news`") or die(mysqli_error($con));
$totalnews = mysqli_num_rows($result);
$result = mysqli_query($con, "SELECT * FROM `news` WHERE DATE(date) = '$date'") or die(mysqli_error($con));
$todaysnews = mysqli_num_rows($result);
$generatestotal = 0;
$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestotal = $generatestotal + $row['generated'];
}
$result = mysqli_query($con, "SELECT * FROM `users` WHERE `date` = '$date'") or die(mysqli_error($con));

$todaysusers = mysqli_num_rows($result);
$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
$activesubscriptions = mysqli_num_rows($result);
$privtotalalts = 0;
$result = mysqli_query($con, "SELECT * FROM `privgenerators`") or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result)) {
	$result2 = mysqli_query($con, "SELECT * FROM `privgenerator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
	$privtotalalts = $privtotalalts + mysqli_num_rows($result2);
}
$privgeneratestotal = 0;
$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$privgeneratestotal = $privgeneratestotal + $row['generated'];
}

?>

<?php include("noob/header.php"); ?>
  	                  <div class="row">
                          
                            
                                                                        
                           
         <div class="col-lg-12">
      
       
             			<?php 
		if (isset($_POST['EmailBtn']))
		{
			$password = mysqli_real_escape_string($con, $_POST['password']);
			$nemail = mysqli_real_escape_string($con, $_POST['nemail']);
			$remail = mysqli_real_escape_string($con, $_POST['remail']);
			if (!empty($password) && !empty($nemail) && !empty($remail))
			{
				if ($cemail == $email)
				{
						if ($md5password == md5($password)) {
							mysqli_query($con, "UPDATE `users` SET `email` = '$nemail' WHERE `users`.`id` = $user_id;") or die(mysqli_error($con));
    							echo '

							<div class="alert alert-success">
  <strong>Success!</strong>  Email has been changed successfully!
						</div>
						';
						}
						else {
							echo '

								<div class="alert alert-danger">
  <strong>ERROR!</strong>  Current Password was not correct, Password did not changed
					</div>
						';
						}
					}
				else
				{
					echo '

							<div class="alert alert-danger">
  <strong>ERROR!</strong> Current Email was incorrect, Email did not changed! 
					</div>
					';
				}
			}
			else
			{
				echo '

						<div class="alert alert-danger">
  <strong>ERROR!</strong> Please fill in all fields
					</div>
				';
			}
		}
		?>
        <?php 
        if (isset($_POST['ProfileBtn']))
        {
            $cprofile = mysqli_real_escape_string($con, $_POST['cprofile']);
            if (!empty($cprofile))
            {
                            mysqli_query($con, "UPDATE `users` SET `profile_img` = '$cprofile' WHERE `users`.`id` = $user_id;") or die(mysqli_error($con));
                                echo '

                            <div class="alert alert-success">
  <strong>Success!</strong>  Profile Image has been changed successfully!
                        </div>
                        ';
            }
            else
            {
                echo '

                        <div class="alert alert-danger">
  <strong>ERROR!</strong> Please fill in all fields
                    </div>
                ';
            }
        }
        ?>
		<?php 
		if (isset($_POST['PassBtn']))
		{
		    
			$password = $_POST['password'];
			$npassword = mysqli_real_escape_string($con, $_POST['npassword']);
			$rpassword = mysqli_real_escape_string($con, $_POST['rpassword']);
			if (!empty($password) && !empty($npassword) && !empty($rpassword))
			{
				if ($npassword == $rpassword)
				{
				        $pass_encrypted = password_hash($password, PASSWORD_DEFAULT);
				         $newPassword = password_hash($npassword, PASSWORD_DEFAULT);
						if (password_verify($password,  $pass_encrypted)) {
							mysqli_query($con, "UPDATE `users` SET `password` = '$newPassword' WHERE `users`.`id` = $user_id;") or die(mysqli_error($con));
    							echo '
					    
							<div class="alert alert-success">
  <strong>Success!</strong> Password has been changed successfully!
						</div>
						';
						}
						else {
							echo '
							<div class="alert alert-danger">
  <strong>ERROR!</strong> Current Password was not correct, Password did not changed!
						</div>
						';
						}
					}
				else
				{
					echo '
				<div class="alert alert-danger">
  <strong>ERROR!</strong> New passwords did not match, Password did not changed! 
					</div>
					';
				}
			}
			else
			{
				echo '
		
				
					<div class="alert alert-info">
  <strong>Info!</strong> Please fill in all fields 
				</div>
				';
			}
		}
		?>
						<?php 
        if (isset($_POST['UserPost']))
        {
            $StatusTitle = mysqli_real_escape_string($con, $_POST['StatusTitle']);
            $StatusMessage = mysqli_real_escape_string($con, $_POST['StatusMessage']);
            if (!empty($StatusMessage))
            {
                            
mysqli_query($con, "INSERT INTO `userpost` (`title`, `message`, `writer`) VALUES ('$StatusTitle', '$StatusMessage', '$username' )") or die(mysqli_error($con));
                                echo '

                            <div class="alert alert-success">
  <strong>Success!</strong>  Status Successfully Added!
                        </div>
                        ';
            }
            else
            {
                echo '

                        <div class="alert alert-danger">
  <strong>ERROR!</strong> Please fill in all fields
                    </div>
                ';
            }
        }
        ?>
		
	   		<?php 
		if (isset($_POST['fu']))
		{
			$password = mysqli_real_escape_string($con, $_POST['password']);
			$nfirst_last_name = mysqli_real_escape_string($con, $_POST['nfirst_last_name']);
			$rfirst_last_name = mysqli_real_escape_string($con, $_POST['rfirst_last_name']);
			if (!empty($password) && !empty($nfirst_last_name) && !empty($rfirst_last_name))
			{
				if ($nfirst_last_name == $rfirst_last_name)
				{
					$newpassword = ($nfirst_last_name);
						if ($md5password == md5($password)) {
							mysqli_query($con, "UPDATE `users` SET `first_last_name` = '$newpassword' WHERE `users`.`id` = $user_id;") or die(mysqli_error($con));
    							echo '
					    
							<div class="alert alert-success">
  <strong>Success!</strong> Your Fullname has been changed successfully!
						</div>
						';
						}
						else {
							echo '
							<div class="alert alert-danger">
  <strong>ERROR!</strong> Current Password was not correct, Full Name did not changed!
						</div>
						';
						}
					}
				else
				{
					echo '
				<div class="alert alert-danger">
  <strong>ERROR!</strong> Your full names did not match! Fullname did not change 
					</div>
					';
				}
			}
			else
			{
				echo '
		
				
					<div class="alert alert-danger">
  <strong>Info!</strong> Please fill in all fields 
				</div>
				';
			}
		}
		?>
		</div>

        
		
		<p></p>
                           
         <div class="col-lg-3">
				<div class="card card-colour card-primary">
					<center><h5 class="card-heading">
                        Profile Information
                    </h5></center>
					<div class="card-body">
                                        <?php
                                            //Query to grab users profile image
                                            $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<img src="' .$row['profile_img']. '" alt="Profile Image" title="" class="img-circle img-thumbnail img-responsive">';
                                            }
                                            
                                       ?>

                    <!-- inbox dropdown end -->

                                    <hr>

                                    <div class="text-center">
                       
                             <center> <h3><?php echo $first_last_name;?></h3>  </center>
                            <p class="text-muted font-13"><strong>Date:</strong> <span class="m-l-15"><?php echo $date;?></span></p>

                                       <p class="text-muted font-13"><strong>User ID:</strong><span class="m-l-15"><?php echo $_SESSION['id']; ?></span></p>
                                                
                                                 <p class="text-muted font-13"><strong>You're A </strong> <span class="m-l-15">
					<?php
					if (($_SESSION['rank']) == "1") {
					echo 'Customer';}?>
					<?php
					if (($_SESSION['rank']) == "4") {
					echo 'Cracker';}?>
					<?php
					if (($_SESSION['rank']) == "5") {
					echo 'Admin';}?>
					
												 </span></p>
                                                
                                                <p class="text-muted font-13"><strong>Username:</strong> <span class="m-l-15"><?php echo $username;?></span></p>

                                                <p class="text-muted font-13"><strong>Email:</strong><span class="m-l-15"> <?php echo $_SESSION['email']; ?></span></p>

                                              

                                    </div>


                   
 </div>
                                    </div>
                                </div>

  <div class="col-lg-3">
				<div class="card card-colour card-primary">
					<center><h5 class="card-heading">
                        Change Fullname
                    </h5></center>
					<div class="card-body">
		<form action="" method="POST">
					<div class="form-group">
						<input name="password" type="password" class="form-control" placeholder="Enter your password">
					</div>
					<div class="form-group">
						<input name="nfirst_last_name" type="text" class="form-control" placeholder="New FullName">
					</div>
					<div class="form-group">
						<input name="rfirst_last_name" type="text" class="form-control" placeholder="Repeat FullName">
					</div>
					<div class="form-group">
						<center><button type="submit" name="fu" class="btn btn-primary btn-block">Change FullName</button></center>
					</div>
					</form>
					</div>
				</div>
		</div>

<div class="col-lg-3">
				<div class="card card-colour card-primary">
					<center><h5 class="card-heading">
                        Change Password
                    </h5></center>
					<div class="card-body">
		<form action="" method="POST">
					<div class="form-group">
						<input name="password" type="password" class="form-control" placeholder="Current Password">
					</div>
					<div class="form-group">
						<input name="npassword" type="password" class="form-control" placeholder="New Password">
					</div>
					<div class="form-group">
						<input name="rpassword" type="password" class="form-control" placeholder="Repeat Password">
					</div>
					<div class="form-group">
						<center><button type="submit" name="PassBtn" class="btn btn-primary btn-block">Change Password</button></center>
						</div>
					</form>
					</div>
				</div>
		</div>                               
                           
         <div class="col-lg-3" >
      
                <div class="card card-colour card-primary">
                    <center><h5 class="card-heading">
                        Change Profile Image
                    </h5></center>
                    <div class="card-body">

                        <form action="" method="POST">
                    <div class="form-group">
                        <input name="cprofile" type="text" class="form-control" placeholder="Image link here">
                    </div>
                    <div class="form-group">
                        <center><button type="submit" name="ProfileBtn" class="btn btn-primary btn-block">Change Image</button></center>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
                
    <?php include("noob/footer.php"); ?>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });

                $(".knob").knob();

            });
        </script>
<script src="js/ZeroClipboard.js" ></script>


    </body>

</html>