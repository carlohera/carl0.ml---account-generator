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
header('Location: index.php');
exit();
}
if(isset($_POST['username']) && isset($_POST['password'])){
$username = sec_tag($con, $_POST['username']);
$password = sec_tag($con, md5($_POST['password']));
$result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error($con));
$ip = sec_tag($con, $_SERVER['REMOTE_ADDR']);
mysqli_query($con, "INSERT INTO `login_logs` (`username`, `ip`) VALUES ('$username', '$ip')") or die(mysqli_error($con));
if(mysqli_num_rows($result) < 1){
header("Location: login.php?error=incorrect-password");
}
while($row = mysqli_fetch_array($result)){
if($password != $row['password']){
header("Location: login.php?error=incorrect-password");
}elseif($row['status'] == "0"){
header("Location: login.php?error=banned");
}else{
$_SESSION['id'] = $row['id'];
$_SESSION['username'] = $username;
$_SESSION['email'] = $row['email'];
$_SESSION['rank'] = $row['rank'];
header("Location: index.php");
}
}
}
?>
<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
      <?php echo $website ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?php echo $website ?>, Account, Premium, Cheap, Netflix, free, Spotify, Hulu, account gen, account generator, Best, Minecraft, Account Gen, Amazon, account, topaccgen, best account generator, cheap account generator, topaccgen generator">
    <meta name="description" content="<?php echo $website ?> is the best account generator on the market! Generate thousands of premium accounts for a small one time cost. Generate Netflix, Hulu, Minecraft, and much more Free to Sign Up!">
    <meta name="author" content="Best Account Generator">
    <link rel="shortcut icon" href="<?php echo $favicon ?>">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="ll_files/bootstrap.css">
    <link rel="stylesheet" href="ll_files/icons.css">
    <link rel="stylesheet" type="text/css" href="ll_files/style.css">
    <link rel="stylesheet" type="text/css" href="ll_files/responsive.css">
    <link rel="stylesheet" type="text/css" href="ll_files/color.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  </head>
  <body>
    <div class="pageloader" style="display: none;">
      <div class="loader">
        <div class="cssload-thecube"> 
          <div class="cssload-cube cssload-c1">
          </div> 
          <div class="cssload-cube cssload-c2">
          </div> 
          <div class="cssload-cube cssload-c4">
          </div> 
          <div class="cssload-cube cssload-c3">
          </div>
        </div>                                    
      </div>
    </div>
    <!-- Page Loader -->
    <div class="login-page" style="height: 600px;">
      <div class="login-box">
        <br>
        <center> 
          <h3 style="font-weight:bold;color:#6991f7;text-shadow: 0px 0px 7px #6991f7">
            Welcome To <?php echo $website ?>
          </h3>
        </center>
        <strong>Please Verify Your Email
        </strong>
    <td width="732" valign="top">
     <strong>
     Thank You For Registering With Us To Continue Please Verify Your Email With The Email That Was Sent After Registering
     </strong>
      <strong>Make sure to visit the "Account List Page" to see what account types we have to offer. 
     
     Here at <?php echo $website ?> we have a fully working chatbox so you can chat to other members of the community.  <strong>
     <br>
     <a class="btn btn-default btn-block" href="login.php?Welcome">Login Now</a>


        </div>
    </section>
    <!-- End main content-->
    
    

</div>
<!-- End wrapper-->
<style>
  a:hover {
    cursor: pointer;
  }
  a {
    display: inline-block;
    position: relative;
    text-decoration: none;
    &:hover {
      @linkBlue: #0000ee;
      a {
        color: @linkBlue;
        display: inline-block;
        position: relative;
        text-decoration: none;
        &:before {
          background-color: @linkBlue;
          content: '';
          height: 2px;
          position: absolute;
          bottom: -1px;
          transition: width 0.3s ease-in-out;
          width: 100%;
        }
        &:hover {
          &:before {
            width: 0;
          }
        }
      }
</style>
</form>		
</div>
</div>
<script src="ll_files/jquery.js">
</script>
<script src="ll_files/bootstrap.js">
</script>
<script src="ll_files/toggles.js">
</script>
<script src="ll_files/isotope.js">
</script>
<script src="ll_files/script.js">
</script>
<script src="assets/js/neon-api.js">
</script>
<script src="assets/js/jquery.validate.min.js">
</script>
<script src="assets/js/neon-login.js">
</script>
<script type="text/javascript">
  jQuery(document).ready(function(){
    var full_height = $(window).height();
    $('.login-page').css({
      "height":full_height            
    }
                        );
  }
                        );
</script>
</body>
<?php
if(isset($_GET['error'])){
echo "<script type='text/javascript'>
$(document).ready(function(){
$('#error').modal('show');
});
</script>"
;
}
?>
</html>
