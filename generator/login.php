
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>carl0.ml generator - login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/iconfonts/puse-icons-feather/feather.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png">
<style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style><style type="text/css">span.im-caret {
    -webkit-animation: 1s blink step-end infinite;
    animation: 1s blink step-end infinite;
}

@keyframes blink {
    from, to {
        border-right-color: black;
    }
    50% {
        border-right-color: transparent;
    }
}

@-webkit-keyframes blink {
    from, to {
        border-right-color: black;
    }
    50% {
        border-right-color: transparent;
    }
}

span.im-static {
    color: grey;
}

div.im-colormask {
    display: inline-block;
    border-style: inset;
    border-width: 2px;
    -webkit-appearance: textfield;
    -moz-appearance: textfield;
    appearance: textfield;
}

div.im-colormask > input {
    position: absolute;
    display: inline-block;
    background-color: transparent;
    color: transparent;
    -webkit-appearance: caret;
    -moz-appearance: caret;
    appearance: caret;
    border-style: none;
    left: 0; /*calculated*/
}

div.im-colormask > input:focus {
    outline: none;
}

div.im-colormask > input::-moz-selection{
    background: none;
}

div.im-colormask > input::selection{
    background: none;
}
div.im-colormask > input::-moz-selection{
    background: none;
}

div.im-colormask > div {
    color: black;
    display: inline-block;
    width: 100px; /*calculated*/
}</style><style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style><div></div></head>




<?php
ob_start();
include 'inc/database.php';
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

    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }

if(isset($_POST['LogMein'])){
    $username = htmlspecialchars($_POST['usernameoremail']);
  $password = htmlspecialchars($_POST['password']);
  $passwordhashed = password_hash($password, PASSWORD_BCRYPT);
  
    $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' OR `email` = '$username'") or die(mysqli_error($con));
  
    $ip = $_SERVER['REMOTE_ADDR'];
    mysqli_query($con, "INSERT INTO `login_logs` (`username`, `ip`) VALUES ('$username', '$ip')") or die(mysqli_error($con));
    if(mysqli_num_rows($result) < 1)
  {
       header("Location: login.php?error=no-exist");
    }
    while($row = mysqli_fetch_array($result))
  {
    if(password_verify($password,$row['password']))
    {
      if($row['status'] == "0")
      {
      ;;  header("Location: login.php?error=banned");
      }
      if($row['active'] == "0")
      {
      ;;  header("Location: login.php?error=verify");
      }
      else
      {
        $_SESSION['id'] = $row['id'];
        $id = $_SESSION['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['rank'] = $row['rank'];
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        mysqli_query($con, "UPDATE `users` SET `ip` = '$ip' WHERE `id` = '$id'") or die(mysqli_error($con));
                header("Location: index.php");
      }
    }   
    else
    {
           header("Location: login.php?error=incorrect-password");
    } 
    }
}

?>








<body>
          <form method="POST" action="login.php" class="form-signin">
            <div class="form-group">
                <?php 
            if($_GET['error'] == "incorrect-password"){
              echo '<div class="alert alert-danger alert-alt"><center><strong>Your Password Is Incorrect</strong></center> <br> <center>Please Try Again</center></div>';
            } 
            if($_GET['error'] == "banned"){
              echo '<div class="alert alert-danger alert-alt"><center><strong>Your Account Has Been Banned</strong></center></div>';
            } 
            if($_GET['error'] == "no-exist"){
              echo '<div class="alert alert-danger alert-alt"><center><strong>There Isnt An Account With Those Details</strong></center></div>';
            } 
        ?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form action="#">
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" id="usernameoremail" name="usernameoremail" class="form-control" placeholder="Enter Your Username | Email" required>
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="mdi mdi-check-circle-outline"></i></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="mdi mdi-check-circle-outline"></i></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" name="LogMein" id="LogMein" class="btn btn-primary">Login</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked="">
                      Keep me signed in
                    <i class="input-helper"></i></label>
                  </div>
                  <a href="forgotpassword.php" class="text-small forgot-password text-black">Forgot Password</a>
                </div>
                <div class="form-group">
                  
                </div>
                <div class="text-block text-center my-3">
                  <span class="text-small font-weight-semibold">Not a member ?</span>
                  <a href="register.php" class="text-black text-small">Create new account</a>
                </div>
              </form>
            </div>
            <ul class="auth-footer">
              <li><a href="#">Conditions</a></li>
              <li><a href="#">Help</a></li>
              <li><a href="#">Terms</a></li>
            </ul>
            <p class="footer-text text-center">copyright © 2018 Bootstrapdash. All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->


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

<script src="css/toastr.min.js"></script>
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
</body></html>