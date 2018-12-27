<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>carl0.ml generator - reset password</title>
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

include('inc/database.php');
    if(isset($_POST['fpassreset']))
    {
        $email = $con->real_escape_string($_POST['email']);

        $SQLquery = $con->query("SELECT `id` FROM `users` WHERE `email` = '$email'");

        if($SQLquery->num_rows > 0)
        {
            $generate_token = "1234567890abcdefghijklmnopqrstuvwxyz";
            $generate_token = str_shuffle($generate_token);
            $generate_token = substr($generate_token, 0, 15);
	$passwordhashed = password_hash($password, PASSWORD_BCRYPT);
            $special_url = "https://carl0.ml/generator/resetpassword.php?token=$generate_token&email=$email";
            $subject = "carl0.ml | password reset";
            $message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <title>Go Welcome Email</title>
    <!-- Designed by https://github.com/kaytcat -->
    <!-- Header image designed by Freepik.com -->

    <style type='text/css'>
    /* Take care of image borders and formatting */

    img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
    a img { border: none; }
    table { border-collapse: collapse !important; }
    #outlook a { padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass {width:100%;}
    .backgroundTable {margin:0 auto; padding:0; width:100%;!important;}
    table td {border-collapse: collapse;}
    .ExternalClass * {line-height: 115%;}


    /* General styling */

    td {
      font-family: Arial, sans-serif;
      color: #5e5e5e;
      font-size: 16px;
      text-align: left;
    }

    body {
      -webkit-font-smoothing:antialiased;
      -webkit-text-size-adjust:none;
      width: 100%;
      height: 100%;
      color: #5e5e5e;
      font-weight: 400;
      font-size: 16px;
    }


    h1 {
      margin: 10px 0;
    }

    a {
      color: #2b934f;
      text-decoration: none;
    }


    .body-padding {
      padding: 0 75px;
    }


    .force-full-width {
      width: 100% !important;
    }

    .icons {
      text-align: right;
      padding-right: 30px;
    }

    .logo {
      text-align: left;
      padding-left: 30px;
    }

    .computer-image {
      padding-left: 30px;
    }

    .header-text {
      text-align: left;
      padding-right: 30px;
      padding-left: 20px;
    }

    .header {
      color: #232925;
      font-size: 24px;
    }



    </style>

    <style type='text/css' media='screen'>
        @media screen {
          @import url(http://fonts.googleapis.com/css?family=PT+Sans:400,700);
          /* Thanks Outlook 2013! */
          * {
            
          }
        }
    </style>

    <style type='text/css' media='only screen and (max-width: 599px)'>
      /* Mobile styles */
      @media only screen and (max-width: 599px) {

        table[class*='w320'] {
          width: 320px !important;
        }

        td[class*='icons'] {
          display: block !important;
          text-align: center !important;
          padding: 0 !important;
        }

        td[class*='logo'] {
          display: block !important;
          text-align: center !important;
          padding: 0 !important;
        }

        td[class*='computer-image'] {
          display: block !important;
          width: 230px !important;
          padding: 0 45px !important;
          border-bottom: 1px solid #e3e3e3 !important;
        }


        td[class*='header-text'] {
          display: block !important;
          text-align: center !important;
          padding: 0 25px!important;
          padding-bottom: 25px !important;
        }

        *[class*='mobile-hide'] {
          display: none !important;
          width: 0 !important;
          height: 0 !important;
          line-height: 0 !important;
          font-size: 0 !important;
        }


      }
    </style>
  </head>
  <body  offset='0' class='body' style='padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none' bgcolor='#ffffff'>
  <table align='center' cellpadding='0' cellspacing='0' width='100%' height='100%'>
    <tr>
      <td align='center' valign='top' style='background-color:#ffffff' width='100%'>

      <center>
        <table cellspacing='0' cellpadding='0' width='600' class='w320'>
          <tr>
            <td align='center' valign='top'>

              <table class='force-full-width' cellspacing='0' cellpadding='0' bgcolor='#232925'>
                <tr>
                  <td style='background-color:#232925' class='logo'>
                    <br>
                    <a href='#'><img src='https://imgur.com/hfWhSH9.png' alt='Logo'></a>
                  </td>
                  <td class='icons'>
                    <br>

                  </td>
                </tr>
              </table>

              <table cellspacing='0' cellpadding='0' class='force-full-width' bgcolor='#232925'>
                <tr>
                  <td class='computer-image'>
                    <br>
                    <br class='mobile-hide' />
                    <img style='display:block;' width='224' height='213' src='https://www.filepicker.io/api/file/CoMxXSlVRDuRQWNwnMzV' alt='hello'>
                  </td>
                  <td style='color: #ffffff;' class='header-text'>
                    <br>
                    <br>
                    <span style='font-size: 24px;'>You have requested a new password!</span><br><br>
                    Reset your password by clicking the button below!
                    <br>
                    <br>
                      <div><!--[if mso]>
                        <v:rect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='http://' style='height:40px;v-text-anchor:middle;width:150px;' stroke='f' fillcolor='#2b934f'>
                          <w:anchorlock/>
                          <center>
                        <![endif]-->
                            <a href='https://carl0.ml/generator/resetpassword.php?token=$generate_token&email=$email'
                        style='background-color:#2b934f;color:#ffffff;display:inline-block;font-family:Helvetcia, sans-serif;font-size:16px;font-weight:light;line-height:40px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;'>Reset Password</a>
                          <!--[if mso]>
                            </center>
                          </v:rect>
                        <![endif]-->
                      </div>
                  </td>
                </tr>
              </table>


              <table class='force-full-width' cellspacing='0' cellpadding='30' bgcolor='#ebebeb'>
                <tr>
                  <td>
                    <table cellspacing='0' cellpadding='0' class='force-full-width'>
                      <tr>
                        <td>

                          <span class='header'>Questions?</span><br>
                          Feel free to <a href='mailto:bbx.carlo@yahoo.com'>contact us</a> anytime for questions about your account.<br><br>
                          Sincerely,<br>
                          carl0.ml staff
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>


              <table class='force-full-width' cellspacing='0' cellpadding='20' bgcolor='#2b934f'>
                <tr>
                  <td style='background-color:#2b934f; color:#ffffff; font-size: 14px; text-align: center;'>
                    © 2019 All Rights Reserved
                  </td>
                </tr>
              </table>


            </td>
          </tr>
        </table>

      </center>
      </td>
    </tr>
  </table>
  </body>
</html>";
                  $headers = "MIME-Version: 1.0" . "\r\n";
                  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                  // More headers
                  $headers .= 'From: <no-reply@carl0.ml>' . "\r\n"
            mail($email,$subject,$message,$headers);

            $con->query("UPDATE `users` SET token = '$generate_token' WHERE email = '$email'");

            echo '<br><p><center> <div class="alert alert-success">
  <strong>Successful</strong> Please check your email for a password reset link , Make sure to check your SPAM folder if its not in your inbox - Thanks 
</div></center>';
        }
        else
        {
            echo '<br><p> <center><div class="alert alert-danger">
  <strong>Error</strong> This email is not in our database, please use the email you signed up with 
</div> </center></p>';
        }
     }
     $result = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
    $website = $row['website'];
    $favicon = $row['favicon'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo $favicon;?>">

    <!-- Page title -->
    <title>Forgot Password</title>

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


            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">

                </div>
            </div>
<div class="panel panel-filled">
                <div class="panel-body">
                     <form class="form-signin" action="forgotpassword.php" method="POST">
                        <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form action="#">
                <div class="form-group">

                            <label class="control-label" for="email">Your Email</label>
                            <form method="post" action="forgotpassword.php" style="margin-left: 500px; margin-right: 500px;">
                            <input type="text" id="email" name="email" class="form-control" placeholder="Enter your email here..." required>
                            <span class="help-block small">Please enter your email to recive a message </span>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary brn-block" name="fpassreset">Submit</button>
                            <a class="btn btn-default pull-right" href="login.php">Login</a>
                            <a class="btn btn-default pull-right" href="register.php">Register</a>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->
    
   


</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="vendor/pacejs/pace.min.js"></script>
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- App scripts -->
<script src="scripts/luna.js"></script>

</body>

</html>