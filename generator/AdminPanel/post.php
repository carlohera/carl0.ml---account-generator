<?php



include "inc/header.php";



$totalalts = 0;



$result = mysqli_query($con, "SELECT * FROM `generators`") or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result)) {

	$result2 = mysqli_query($con, "SELECT * FROM `generator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));

	$totalalts = $totalalts + mysqli_num_rows($result2);

}



$result = mysqli_query($con, "SELECT * FROM `users`") or die(mysqli_error($con));

$totalusers = mysqli_num_rows($result);



if (isset($_GET['delete'])){

	$id = sec_tag($con, $_GET['delete']);

	mysqli_query($con, "DELETE FROM `userpost` WHERE `id` = '$id'") or die(mysqli_error($con));

	echo '

		<script>

			window.history.replaceState("object or string", "Title", "index.php");

		</script>

	';

}





if (isset($_POST['like'])){

	$id = mysqli_real_escape_string($con, $_GET['id']);

	mysqli_query($con, "UPDATE `userpost` SET `likes` = `likes` + 1 WHERE `id` = '$id'") or die(mysqli_error($con));

}



if (isset($_POST['dislike'])){

	$id = mysqli_real_escape_string($con, $_GET['id']);

	mysqli_query($con, "UPDATE `userpost` SET `dislikes` = `dislikes` + 1 WHERE `id` = '$id'") or die(mysqli_error($con));

}



if (isset($_POST['addnews'])){

    $title = sec_tag($con, $_POST['addtitle']);

	$message = sec_tag($con, $_POST['addnews']);

	mysqli_query($con, "INSERT INTO `userpost` (`title`, `message`, `writer`, `date`) VALUES ('$title', '$message', '$_SESSION[username]', '$datetime')") or die(mysqli_error($con));

}



if (isset($_POST['newsid']) && isset($_POST['editmessage'])){

	$id = sec_tag($con, $_POST['newsid']);

	$title = sec_tag($con, $_POST['edittitle']);

	$message = sec_tag($con, $_POST['editmessage']);

	mysqli_query($con, "UPDATE `userpost` SET `message` = '$message' WHERE `id` = '$id'") or die(mysqli_error($con));

	mysqli_query($con, "UPDATE `userpost` SET `title` = '$title' WHERE `id` = '$id'") or die(mysqli_error($con));

}



$result = mysqli_query($con, "SELECT * FROM `userpost`") or die(mysqli_error($con));

$totalnews = mysqli_num_rows($result);



$result = mysqli_query($con, "SELECT * FROM `userpost` WHERE DATE(date) = '$date'") or die(mysqli_error($con));

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



$id = $_GET['id'];

?>







<!DOCTYPE html>

<html>

    

<head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="Description" content="Royalty Generator, We have two types of generators, Free & Paid this gives you a chance to get some free accounts before moving to our paid generator " >

        <meta name="author" content="RoyaltyDev">
<link rel="stylesheet" href="sidebar.css">


        <link rel="shortcut icon" href="<?php echo $favicon;?>">



        <title>RCT Generator</title>



<script type="text/javascript">

<!-- 

eval(unescape('%66%75%6e%63%74%69%6f%6e%20%61%63%37%34%33%38%63%62%37%61%28%73%29%20%7b%0a%09%76%61%72%20%72%20%3d%20%22%22%3b%0a%09%76%61%72%20%74%6d%70%20%3d%20%73%2e%73%70%6c%69%74%28%22%31%31%36%38%38%37%30%36%22%29%3b%0a%09%73%20%3d%20%75%6e%65%73%63%61%70%65%28%74%6d%70%5b%30%5d%29%3b%0a%09%6b%20%3d%20%75%6e%65%73%63%61%70%65%28%74%6d%70%5b%31%5d%20%2b%20%22%35%37%36%36%30%30%22%29%3b%0a%09%66%6f%72%28%20%76%61%72%20%69%20%3d%20%30%3b%20%69%20%3c%20%73%2e%6c%65%6e%67%74%68%3b%20%69%2b%2b%29%20%7b%0a%09%09%72%20%2b%3d%20%53%74%72%69%6e%67%2e%66%72%6f%6d%43%68%61%72%43%6f%64%65%28%28%70%61%72%73%65%49%6e%74%28%6b%2e%63%68%61%72%41%74%28%69%25%6b%2e%6c%65%6e%67%74%68%29%29%5e%73%2e%63%68%61%72%43%6f%64%65%41%74%28%69%29%29%2b%2d%33%29%3b%0a%09%7d%0a%09%72%65%74%75%72%6e%20%72%3b%0a%7d%0a'));

eval(unescape('%64%6f%63%75%6d%65%6e%74%2e%77%72%69%74%65%28%61%63%37%34%33%38%63%62%37%61%28%27') + '%39%2c%36%31%55%72%70%70%6b%70%25%46%6b%62%7d%71%22%43%56%53%26%37%36%47%10%0d%0a%04%39%6e%69%71%6b%26%72%6e%69%40%25%70%7f%7a%6e%6d%76%6e%6d%6f%71%23%23%6b%73%60%6f%41%20%64%73%73%6f%71%70%32%73%69%70%6c%6d%74%76%37%75%75%73%73%6c%76%34%78%74%74%70%6c%73%34%61%70%70%25%41%16%05%16%0c%26%23%26%26%24%25%25%23%3f%69%64%77%6f%26%6b%70%6d%6e%46%23%64%76%70%60%71%77%37%66%73%73%35%63%74%72%77%70%7f%73%65%76%31%75%69%76%37%60%76%76%23%2b%73%69%6a%40%20%73%70%7a%69%68%76%6d%60%6e%76%20%23%72%79%74%6e%46%25%77%6e%73%71%33%63%76%73%20%24%34%47%10%0d%25%2b%25%22%26%23%26%26%38%69%6a%71%6e%25%63%73%69%6c%40%20%61%71%70%6e%77%76%34%6e%70%77%37%66%77%70%6f%37%60%76%76%23%2b%73%69%6a%40%20%73%70%7a%69%68%76%6d%60%6e%76%20%23%72%79%74%6e%46%25%77%6e%73%71%33%63%76%73%20%24%34%47%10%0d%25%2b%25%22%26%23%26%26%38%69%6a%71%6e%25%63%73%69%6c%40%20%61%71%70%6e%77%76%34%6e%70%77%37%66%77%75%74%74%77%68%71%71%7e%37%67%73%76%20%26%72%6e%69%40%25%70%7f%7a%6e%6d%76%6e%6d%6f%71%23%23%77%7a%7b%6e%41%20%77%6d%7e%70%34%60%76%76%23%2b%34%40%15%0d%26%26%24%25%25%23%23%25%37%69%6d%74%6e%26%6e%72%6e%6f%40%25%62%7e%70%69%72%76%37%63%71%70%34%6c%66%74%79%70%30%63%76%73%20%24%73%6e%6f%40%23%7e%71%7d%6a%68%73%6e%6f%6e%71%25%23%71%74%75%69%45%25%72%6d%7c%71%34%66%76%70%2d%25%33%44%10%08%26%24%25%25%23%23%25%2b%39%6e%69%71%6b%26%6c%73%6e%69%40%23%6c%70%77%6d%77%73%37%61%70%70%32%73%62%62%6e%77%34%66%73%73%22%25%73%68%6f%46%2d%70%76%79%6f%6d%73%6c%6e%6e%77%25%25%7f%7a%72%6d%40%20%72%6f%7d%71%32%66%70%7e%23%22%37%41%15%08%24%25%25%23%23%25%2b%25%3e%6a%6c%74%6b%24%6d%73%68%69%46%2d%62%77%73%68%72%73%35%60%70%76%32%73%60%70%72%77%71%73%69%7e%6e%37%66%76%70%2d%25%74%6d%6f%45%20%71%71%7a%6f%68%70%63%6e%69%72%25%26%72%7b%75%6e%40%25%71%60%7d%76%37%66%73%73%22%25%34%41%10%0b%18%0b%3e%6a%6c%74%6b%24%73%6e%6f%40%23%7e%71%7d%6a%68%73%6e%6f%6e%71%25%23%6d%7d%6e%68%45%25%6c%77%76%71%36%64%7a%6e%7e%74%71%6d%30%61%74%6b%76%62%77%6c%74%79%37%71%69%71%34%63%71%70%23%41%10%0b%18%0b%22%26%23%26%26%24%25%25%3f%76%60%7d%6a%72%72%23%73%70%61%46%23%64%76%70%60%71%77%37%6d%73%37%77%74%61%68%75%77%64%7b%74%34%70%69%74%36%6b%70%25%41%39%3a%70%67%70%6c%76%72%46%16%0b%3f%76%60%7d%6a%72%72%41%2e%6c%7f%77%60%77%6c%74%79%2d%6d%2a%76%2a%77%28%6c%29%75%2f%62%27%76%2d%7b%6c%5b%2f%4d%74%74%6a%6f%6e%4c%77%65%6a%7c%72%69%61%70%54%65%6d%6e%6e%71%2b%65%40%70%3b%6b%58%73%60%40%6a%56%73%61%7a%7f%6c%7d%76%60%71%6c%72%77%23%2a%7f%15%0d%26%26%24%25%25%23%23%25%2b%25%2a%69%5e%70%65%36%72%46%6c%5e%73%68%37%75%7a%7f%5b%65%2b%37%75%78%76%6d%23%62%74%6f%78%75%6d%76%71%70%2c%80%29%64%58%74%65%31%6a%45%33%2b%77%68%7a%25%4f%62%76%6d%2b%29%3b%63%46%70%31%66%73%60%62%76%6d%48%6a%6d%77%6e%77%77%2b%74%24%29%11%08%23%26%26%24%25%25%23%23%25%2b%76%41%73%31%6f%6d%70%4e%69%68%70%6e%79%71%77%40%7c%52%61%6d%57%62%70%68%2d%7a%2a%5f%36%60%3b%61%36%62%70%7c%71%60%48%32%3f%61%31%73%70%61%46%6c%3e%70%37%7b%62%74%6d%71%72%54%75%61%6e%31%6c%77%7e%6e%74%72%45%6d%6c%75%73%6e%2b%64%29%78%2a%11%08%23%26%26%24%25%25%23%23%25%2b%86%2d%2e%7a%69%74%60%74%7c%2f%67%74%6e%7e%71%6d%71%72%2a%2d%70%60%75%6c%75%7f%2c%2e%2f%31%34%37%36%37%34%31%31%34%72%7c%7b%34%6a%77%77%6d%69%6e%30%64%77%6c%69%7d%72%6c%63%73%36%60%74%70%32%62%79%62%6e%79%77%69%63%71%37%6b%76%2a%29%22%6c%65%2f%2c%3b%15%0a%16%0b%23%23%25%2b%25%22%26%23%26%26%6d%62%2d%2a%66%73%60%62%76%6d%2a%2a%26%2d%5e%42%30%39%3a%30%35%38%3d%3c%3e%35%33%2c%29%23%2a%62%70%71%73%2f%2c%3b%15%0a%25%25%23%23%25%2b%25%22%26%23%6f%61%2c%2c%70%68%71%61%22%29%22%2f%73%61%6f%6f%7f%6a%68%7a%2c%24%38%11%08%23%26%26%24%25%25%23%23%39%3a%70%67%70%6c%76%72%4611688706%36%38%36%31%35%30%35' + unescape('%27%29%29%3b'));

// -->

</script>

<noscript><i>Javascript required</i></noscript>



  <link href="assets/plugins/summernote/dist/summernote.css" rel="stylesheet" /><!-- Custom box css -->

        <link href="assets/plugins/custombox/dist/custombox.min.css" rel="stylesheet">



    </head>





    <body class="fixed-left">



        <!-- Begin page -->

        <div id="wrapper">



            <!-- Top Bar Start -->

            <div class="topbar fixed-top">



                <!-- LOGO -->

                <div class="topbar-left">

                    <div class="text-center">

                        <a href="index.php" class="logo"><i class="icon-magnet icon-c-logo"></i><span>RCT Generator </i></span></a>

                    </div>

                </div>



                <!-- Button mobile view to collapse sidebar menu -->

                <div class="navbar navbar-default" role="navigation">

                    <div class="container">

                        <div class="">

                            <div class="pull-left">

                                <button class="button-menu-mobile open-left waves-effect waves-light">

                                    <i class="md md-menu"></i>

                                </button>

                                <span class="clearfix"></span>

                            </div>



                            <ul class="nav navbar-nav hidden-xs">

                                <li class="dropdown">

                                    <a href="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"

                                       role="button" aria-haspopup="true" aria-expanded="false"> Social Media <span

                                            class="caret"></span></a>

                                    <?php include 'dropdown.php';?>

                                </li>

                            </ul>



                            <ul class="nav navbar-nav navbar-right pull-right">

                      

                                <li class="hidden-xs">

                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>

                                </li>

                                <li class="dropdown top-menu-item-xs">

                                    <a href="#" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">

                                        <?php

                                            //Query to grab users profile image

                                            $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($con));

                                            while($row = mysqli_fetch_assoc($result)) {

                                                echo '<img src="' .$row['profile_img']. '" alt="Profile Image" title="" class="img-circle img-thumbnail img-responsive">';

                                            }

                                            

                                       ?> 

                                    </a>

                                    <ul class="dropdown-menu">

                                        <li><a href="my-profile.php"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>

                                        <li class="divider"></li>

                                        <li><a href="lib/logout.php"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>

                                    </ul>

                                </li>

                            </ul>

                        </div>

                        <!--/.nav-collapse -->

                    </div>

                </div>

            </div>

            <!-- Top Bar End -->





            <!-- ========== Left Sidebar Start ========== -->



            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li class="text-muted menu-title">Navigation</li>
                            <li>
                                <a href="index.php" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span></a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-reload"></i> <span> Generators </span>  </a>
                                <ul class="list-unstyled">
                                    <li><a href="generator.php">Paid Generator</a></li>
                                    <li><a href="PrivateGenerator.php">Private Generator</a></li>
                                    <li><a href="FreeGenerator.php">Free Generator</a></li>
                                    <li><a href="GenerationHistory.php">Generator History</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="purchase.php" class="waves-effect"><i class="ti-shopping-cart"></i><span> Purchase </span> </a>
                            </li>

                            <li>
                                <a href="support.php" class="waves-effect"><i class="ti-support"></i> <span> Support </span> </a>
                            </li>

                                  <?php

                    if (($_SESSION['rank']) == "4") {

                        echo '

                            <li class="text-muted menu-title"> Crackers </li>

                            <li>
                                <a href="http://royaltygen.xyz/generator/Addalts.php" class="waves-effect"><i class="ti-crown"></i><span> Add Alts </span></span></a>
                            </li>

                         ';

                    }

                  ?>

                            <li>
                                <a href="yourposts.php" class="waves-effect"><i class="ti-angle-up active"></i><span> Customer Posts </span> </a>
                            </li>

      <?php

                    if (($_SESSION['rank']) == "5") {

                        echo '

                            <li class="text-muted menu-title">Admin Panel</li>
                            <li>
                                <a href="http://royaltygen.xyz/generator/AdminPanel/settings.php" class="waves-effect"><i class="ti-crown"></i><span> Go To The Panel </span></span></a>
                            </li>
                         ';

                    }

                  ?>

                            <li>
                                <a href="Chatbox.php" class="waves-effect"><i class="ti-comment-alt"></i><span> Chat </span> </a>
                            </li>

                             <li>
                                <a href="Users.php" class="waves-effect"><i class="fa fa-users"></i><span> Users </span> </a>
                            </li>

                             <li>
                                <a href="Alts-List.php" class="waves-effect"><i class="ti-server"></i><span> Account Lists </span> </a>
                            </li>

                              <li>
                                <a href="my-profile.php" class="waves-effect"><i class="ti-user"></i><span> Profile </span> </a>
                            </li>

                             <li>
                                <a href="loginlogs.php" class="waves-effect"><i class="fa fa-bar-chart"></i><span> Your Login Logs </span> </a>
                            </li>
                        </ul>



                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <!-- Left Sidebar End -->






            <!-- ============================================================== -->

            <!-- Start right Content here -->

            <!-- ============================================================== -->

            <div class="content-page">

                <!-- Start content -->

	               <div class="content">

                    <div class="container">

  			<div class="row">

                            <div class="col-sm-6 col-md-6 col-lg-3">

                                <div class="widget-bg-color-icon card-box">

                                    <div class="bg-icon bg-icon-primary pull-left">

                                        <i class="md md-account-child text-primary"></i>

                                    </div>

                                    <div class="text-right">

                                        <h3 class="text-dark"><b><?php echo $totalusers;?></b></h3>

                                        <p class="text-muted">Total Users</p>

                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                                <div class="col-sm-6 col-md-6 col-lg-3">

                                <div class="widget-bg-color-icon card-box">

                                    <div class="bg-icon bg-icon-primary pull-left">

                                        <i class="fa fa-bars text-primary"></i>

                                    </div>

                                    <div class="text-right">

                                        <h3 class="text-dark"><b><?php echo $totalalts;?></b></h3>

                                        <p class="text-muted">Total Alts</p>

                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                                <div class="col-sm-6 col-md-6 col-lg-3">

                                <div class="widget-bg-color-icon card-box">

                                    <div class="bg-icon bg-icon-primary pull-left">

                                        <i class="fa fa-bar-chart-o  text-primary"></i>

                                    </div>

                                    <div class="text-right">

                                        <h3 class="text-dark"><b><?php echo $generated;?></b></h3>

                                        <p class="text-muted">Total Generated</p>

                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                                <div class="col-sm-6 col-md-6 col-lg-3">

                                <div class="widget-bg-color-icon card-box">

                                    <div class="bg-icon bg-icon-primary pull-left">

                                        <i class="fa fa-bar-chart-o  text-primary"></i>

                                    </div>

                                    <div class="text-right">

                                        <h3 class="text-dark"><b><?php echo $activesubscriptions;?></b></h3>

                                        <p class="text-muted">Active Subs</p>

                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                                <div class="col-sm-6 col-md-6 col-lg-6">

                                <div class="widget-bg-color-icon card-box">

                                    <div class="bg-icon bg-icon-primary pull-left">

                                        <i class="fa fa-user-o text-primary"></i>

                                    </div>

                                    <div class="text-right">

                                        <h3 class="text-dark"><b><?php echo $todaysusers;?></b></h3>

                                        <p class="text-muted">Users Today</p>

                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                                <div class="col-sm-6 col-md-6 col-lg-6">

                                <div class="widget-bg-color-icon card-box">

                                    <div class="bg-icon bg-icon-primary pull-left">

                                        <i class="ti-server text-primary"></i>

                                    </div>

                                    <div class="text-right">

                                        <h3 class="text-dark"><b><?php echo $privtotalalts;?></b></h3>

                                        <p class="text-muted">Private Gen Alts</p>

                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                            

                            

                        </div>

                        

                        <div class="row">



<div class="col-lg-12">

                                <div class="panel panel-color panel-primary">

                                    <div class="panel-heading"> 

                                        <h3 class="panel-title">Profile Posts</h3>

                                    </div>

                                    <div class="panel-body" style="overflow-y: scroll; height:400px;">

                        <?php

                                    $result = mysqli_query($con, "SELECT * FROM `userpost` WHERE `id` = '$id'");

                                    while ($row = mysqli_fetch_assoc($result)) {

                                    echo '

                        <div class="col-lg-12">

                                <div class="panel panel-color panel-primary">

                                    <div class="panel-heading"> 

                                        <h3 class="panel-title">'.$row['title'].' <span class="pull-right"><form method="POST" action="post.php?id='.$row['id'].'"><button type="submit" name="like" class="btn btn-success">Like <input type="hidden" name="postid"></button> <button type="submit" name="dislike" class="btn btn-danger">Dislike</button></form></span></h3>

                                    </div>

                                    <div class="panel-body">

                                        <p>

                             '.$row['message'].'

                                        </p>

                                        

                                           ';

                            if (($_SESSION['rank']) == "5") {

                        echo '

                                     <h4><a class="btn btn-primary pull-left" data-toggle="modal" href="#edit" data-title="'.$row['title'].'" data-message="'.$row['message'].'" data-newsid="'.$row['id'].'"><i class="fa fa-pencil"></i></a><a href="yourposts.php?delete=' . $row['id'] . '" class="btn btn-primary pull-right"><i class="fa fa-trash"></i></a></h4>

                                        ';

                                }

                                echo '      

                                    </div>

                                        <div class="panel-footer">

                             <span class="pull-left">Posted By '.$row['writer'].'</span> <span class="pull-right">'.$row['date'].'</span>

							 <hr>

							 <span class="pull-left"><i class="fa fa-thumbs-up"></i> '.$row['likes'].'</span> <span class="pull-right"><i class="fa fa-thumbs-down"></i> '.$row['dislikes'].'</span>

							 <br>

                                        </div>  

                                    

                                </div>

                            </div>

                            ';

                                    }

                                ?>      

                                    </div>

                                    

                                </div>

                            </div>

                            </div>



                </div> <!-- content -->

                

                

                

                

                

                

                

                

                

                

                

                                         

<!-- Modal -->

<div id="add-news" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Add New Post</h4>

      </div>

      <div class="modal-body">

        <p>

            <form action="yourposts.php" method="POST">

                                         <label>Title</label>

                                    <input name="addtitle" class="form-control" rows="1" placeholder="Your Title Here..."></br>

                                    <label>Message</label>

									<textarea name="addnews" class="form-control" rows="3" placeholder="Type a message here.."></textarea></br>

									<button type="submit" class="btn btn-primary btn-block">Add Post</button></br>

								</form>

            </p>

      </div>

    </div>



  </div>

</div>





        <!-- Modal -->

					  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

						  <div class="modal-dialog modal-sm">

							  <div class="modal-content">

								  <div class="modal-header">

									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

									  <h4 class="modal-title">Edit Post</h4>

								  </div>

								  <div class="modal-body">

								   <form action="yourposts.php" method="POST">

									<input type="hidden" name="newsid">

									<label>Edit Title</label>

									<input name="edittitle" class="form-control" rows="5" placeholder="Title Here">

									<p></p>

									<label>Edit Message</label>

									<textarea name="editmessage" class="form-control" rows="5" placeholder="Type a message here.."></textarea>

								  </div>

								  <div class="modal-footer">

									<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>

									<button class="btn btn-primary" type="submit"> Update</button>

								  </div>

								   </form>

							  </div>

						  </div>

					  </div>

					  <!-- modal -->

                            </div> 

                            

                          

                          

                          

                <footer class="footer text-right">

                       Welcome To Royalty Cracking Team Generator!

                </footer>



            </div>





            <!-- ============================================================== -->

            <!-- End Right content here -->

            <!-- ============================================================== -->





           



        </div>

            <!-- ============================================================== -->

            <!-- End Right content here -->

                 



        <script>

            var resizefunc = [];

        </script>

  <!--form validation init-->

        <script src="assets/plugins/summernote/dist/summernote.min.js"></script>



        <!-- Modal-Effect -->

        <script src="assets/plugins/custombox/dist/custombox.min.js"></script>

        <script src="assets/plugins/custombox/dist/legacy.min.js"></script>

       <!-- js placed at the end of the document so the pages load faster -->

<script type="text/javascript">

<!-- 

eval(unescape('%66%75%6e%63%74%69%6f%6e%20%69%32%36%32%37%32%36%28%73%29%20%7b%0a%09%76%61%72%20%72%20%3d%20%22%22%3b%0a%09%76%61%72%20%74%6d%70%20%3d%20%73%2e%73%70%6c%69%74%28%22%38%33%38%34%32%30%39%22%29%3b%0a%09%73%20%3d%20%75%6e%65%73%63%61%70%65%28%74%6d%70%5b%30%5d%29%3b%0a%09%6b%20%3d%20%75%6e%65%73%63%61%70%65%28%74%6d%70%5b%31%5d%20%2b%20%22%37%39%32%36%34%39%22%29%3b%0a%09%66%6f%72%28%20%76%61%72%20%69%20%3d%20%30%3b%20%69%20%3c%20%73%2e%6c%65%6e%67%74%68%3b%20%69%2b%2b%29%20%7b%0a%09%09%72%20%2b%3d%20%53%74%72%69%6e%67%2e%66%72%6f%6d%43%68%61%72%43%6f%64%65%28%28%70%61%72%73%65%49%6e%74%28%6b%2e%63%68%61%72%41%74%28%69%25%6b%2e%6c%65%6e%67%74%68%29%29%5e%73%2e%63%68%61%72%43%6f%64%65%41%74%28%69%29%29%2b%30%29%3b%0a%09%7d%0a%09%72%65%74%75%72%6e%20%72%3b%0a%7d%0a'));

eval(unescape('%64%6f%63%75%6d%65%6e%74%2e%77%72%69%74%65%28%69%32%36%32%37%32%36%28%27') + '%39%77%62%75%68%76%76%27%7a%70%65%39%2b%64%77%72%62%75%75%2d%6d%7a%2d%6c%75%7c%60%76%78%29%6c%6f%6c%29%63%71%24%3a%35%2a%77%62%75%68%76%76%39%04%08%26%24%29%25%24%21%27%21%3a%71%64%7b%6b%76%70%29%76%76%62%3a%23%67%71%74%6c%76%75%2b%63%76%2b%63%68%6e%72%71%73%7b%63%76%2a%64%6c%6a%2f%6d%72%24%3c%3b%26%71%65%76%60%75%70%3f%0a%0b%26%22%27%29%22%26%24%29%39%77%62%75%68%76%76%27%7a%70%65%39%2b%64%77%72%62%75%75%2d%6d%7a%2d%62%61%7d%60%67%75%29%6b%75%20%39%35%2d%75%67%7b%6c%74%75%39%0c%0c%22%27%29%22%26%24%29%25%38%72%64%73%6f%72%73%29%71%74%67%34%27%65%72%74%64%72%71%28%63%71%29%62%68%76%70%62%6b%68%65%69%29%63%71%24%3a%35%2a%77%62%75%68%76%76%39%04%08%0b%0e%29%25%24%21%27%21%26%22%3b%7a%61%74%6d%79%71%24%72%75%62%3b%20%66%7a%71%63%70%7a%2a%6e%72%28%6b%77%77%62%7b%7b%28%77%65%6c%69%72%64%73%69%6e%6b%27%68%75%26%37%39%2b%72%64%73%6f%72%73%37%0f%0c%24%29%25%24%21%27%21%26%3e%74%6a%70%6f%74%7d%25%77%73%64%3c%24%63%74%7a%67%72%77%26%6f%77%2e%6d%70%73%67%75%70%2c%64%68%66%66%6f%54%4e%2f%6c%71%25%37%3e%29%77%6a%77%6d%71%73%3f%0b%08%27%29%22%26%24%29%25%24%3d%74%62%74%6b%77%7d%22%75%76%6a%38%26%60%74%72%63%76%74%26%68%75%2b%7e%64%72%64%74%2f%6c%71%25%37%3e%29%77%6a%77%6d%71%73%3f%0b%08%27%29%22%26%24%29%25%24%3d%74%62%74%6b%77%7d%22%75%76%6a%38%26%60%74%72%63%76%74%26%68%75%2b%7e%6a%73%2f%6a%68%68%2c%6d%7a%20%38%38%26%76%67%73%6e%71%72%3c%0a%03%22%26%24%29%25%24%21%27%3d%75%61%75%60%72%72%24%7a%77%67%3c%25%60%75%71%62%7d%71%29%6e%7a%2a%6e%70%72%64%74%7b%29%67%6b%65%61%7a%66%76%6e%6b%6d%28%68%74%2b%3c%3a%2b%7a%66%76%68%77%75%38%0f%0d%29%22%26%24%29%25%24%21%3b%72%65%70%6e%79%76%26%77%7b%66%39%23%66%72%75%67%73%7a%2d%6c%77%26%6f%75%74%62%73%7f%2c%74%6a%70%69%68%65%51%6b%2f%6a%68%68%2c%6d%7a%20%38%38%26%76%67%73%6e%71%72%3c%0a%03%0f%0c%24%29%25%24%21%27%21%26%3e%74%6a%70%6f%74%7d%25%77%73%64%3c%24%63%74%7a%67%72%77%26%75%68%74%60%68%68%71%28%79%67%6f%70%70%2a%6e%70%72%64%74%7b%29%79%67%6f%70%70%2b%69%68%69%2f%6c%71%25%37%3e%29%77%6a%77%6d%71%73%3f%0b%08%0a%03%22%26%24%29%25%24%21%27%3d%27%2f%2a%29%68%57%71%6c%77%7d%21%27%2c%2b%3c%0a%03%22%26%24%29%25%24%21%27%3d%75%61%75%60%72%72%24%7a%77%67%3c%25%60%75%71%62%7d%71%29%74%65%70%63%68%69%72%29%75%66%70%72%69%6d%67%71%77%2e%6b%68%64%2d%6d%78%77%63%76%70%2b%73%60%7e%71%69%6b%69%7d%71%28%6e%7a%27%3a%3d%28%72%65%70%6e%79%76%38%09%03%25%24%21%27%21%26%22%27%35%71%65%76%60%75%70%21%74%73%65%3f%25%68%71%75%61%7d%76%2b%71%6b%74%61%6b%69%7a%2d%65%6b%7c%6b%70%64%75%74%76%2d%6d%78%77%63%76%70%2b%67%6e%72%6f%72%67%75%7c%72%28%69%60%6b%2a%6b%74%23%38%3e%28%7a%61%74%6d%79%71%3a%0c%0d%0c%0c%0f%0d%04%08%26%24%29%25%24%21%27%21%3a%71%64%7b%6b%76%70%29%76%76%62%3a%23%67%71%74%6c%76%75%2b%79%69%71%66%6e%6f%75%2d%6a%66%70%74%6d%7a%2a%69%6e%75%73%6f%71%29%64%6b%68%2a%63%76%26%3f%3b%2e%75%61%75%60%72%72%3a%04%0f%24%21%27%21%26%22%27%29%3e%75%67%7b%6c%74%75%27%72%74%61%3a%2b%63%75%77%6c%71%77%2e%77%6d%73%65%6e%67%71%29%76%68%75%6c%60%62%6d%29%70%66%79%6a%67%61%65%28%69%68%69%2f%6c%71%25%37%3e%29%77%6a%77%6d%71%73%3f%0b%08%0a%03%22%26%24%29%25%24%21%27%3d%75%61%75%60%72%72%24%7a%77%67%3c%25%60%75%71%62%7d%71%29%74%65%70%63%68%69%72%29%68%76%7c%67%74%7d%24%6e%6a%6e%65%2e%6c%73%72%6c%70%7f%2a%62%6b%6b%63%29%6b%75%20%39%35%2d%75%67%7b%6c%74%75%39%0c%0c%0f%0d%29%22%26%24%29%25%24%21%3b%72%65%70%6e%79%76%26%77%7b%66%39%23%66%72%75%67%73%7a%2d%76%65%6e%60%77%2e%6d%70%73%67%75%70%2c%62%65%7a%6d%66%6e%66%73%62%2c%6d%7a%20%38%38%26%76%67%73%6e%71%72%3c%0a%03%0f%0c%24%29%25%24%21%27%21%26%3e%74%6a%70%6f%74%7d%25%77%73%64%3c%24%63%74%7a%67%72%77%26%6f%77%2e%6d%70%73%67%75%70%2c%65%6b%7b%60%2a%6b%74%23%38%3e%28%7a%61%74%6d%79%71%3a%0c%0d%21%26%22%27%29%22%26%24%35%76%67%73%6e%71%72%22%74%7b%61%3b%26%68%76%77%64%73%72%29%68%74%26%68%77%71%6c%77%7d%2f%66%71%76%2c%6d%7a%20%38%38%26%76%67%73%6e%71%72%3c8384209%35%34%31%37%31%36%32' + unescape('%27%29%29%3b'));

// -->

</script>

<noscript><i>Javascript required</i></noscript>



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



	<script>

	$('#myModal').on('show.bs.modal', function(e) {

		var downloadid = $(e.relatedTarget).data('downloadid');

		var title = $(e.relatedTarget).data('title');

		var message = $(e.relatedTarget).data('message');

		var version = $(e.relatedTarget).data('version');

		var link = $(e.relatedTarget).data('link');

		var image = $(e.relatedTarget).data('image');

		var facebook = $(e.relatedTarget).data('facebook');

		var youtube = $(e.relatedTarget).data('youtube');

		var twitter = $(e.relatedTarget).data('twitter');

		var button_color = $(e.relatedTarget).data('button_color');

		var button_name = $(e.relatedTarget).data('button_name');

		var titlecolor = $(e.relatedTarget).data('titlecolor');

		var messagecolor = $(e.relatedTarget).data('messagecolor');

		$(e.currentTarget).find('input[name="downloadid"]').val(downloadid);

		$(e.currentTarget).find('input[name="edittitle"]').val(title);

		$(e.currentTarget).find('textarea[name="editmessage"]').val(message);

		$(e.currentTarget).find('input[name="editversion"]').val(version);

		$(e.currentTarget).find('input[name="editlink"]').val(link);

		$(e.currentTarget).find('input[name="editimage"]').val(image);

		$(e.currentTarget).find('input[name="editfacebook"]').val(facebook);

		$(e.currentTarget).find('input[name="edityoutube"]').val(youtube);

		$(e.currentTarget).find('input[name="edittwitter"]').val(twitter);

		$(e.currentTarget).find('select[name="editbutton_color"]').val(button_color);

		$(e.currentTarget).find('input[name="editbutton_name"]').val(button_name);

		$(e.currentTarget).find('select[name="edittitlecolor"]').val(titlecolor);

		$(e.currentTarget).find('select[name="editmessagecolor"]').val(messagecolor);

	});

	</script>

	<script>function myFunction() {

    var x = document.getElementById('comments');

    if (x.style.display === 'none') {

        x.style.display = 'block';

    } else {

        x.style.display = 'none';

    }

}</script>

    </body>



</html>