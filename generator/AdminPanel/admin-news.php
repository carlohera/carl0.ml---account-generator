<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
  header('Location: ../haha.php');
  exit();
}

$profit = 0;

$result = mysqli_query($con, "SELECT * FROM `subscriptions`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$profit = $profit + $row['price'];
}



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

    $title = sec_tag($con, $_POST['addtitle']);

	$message = sec_tag($con, $_POST['addnews']);

    $colourp = sec_tag($con, $_POST['coloured']);

	mysqli_query($con, "INSERT INTO `news` (`title`, `message`, `writer`, `date`, `colour`) VALUES ('$title', '$message', '$_SESSION[username]', '$datetime', '$colourp')") or die(mysqli_error($con));

}



if (isset($_POST['newsid']) && isset($_POST['editmessage'])){

	$id = sec_tag($con, $_POST['newsid']);

	$title = sec_tag($con, $_POST['edittitle']);

	$message = sec_tag($con, $_POST['editmessage']);

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
$result = mysqli_query($con, "SELECT * FROM `news`") or die(mysqli_error($con));
$totalnews = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `news` WHERE DATE(date) = '$date'") or die(mysqli_error($con));
$todaysnews = mysqli_num_rows($result);

if (isset($_GET['delete'])){
	$id = mysqli_real_escape_string($con, $_GET['delete']);
	mysqli_query($con, "DELETE FROM `news` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "/admin-news.php");
		</script>
	';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $website;?></title>
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/iconfonts/puse-icons-feather/feather.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" 
  integrity="sha384-p2jx59pefphTFIpeqCcISO9MdVfIm4pNnsL08A6v5vaQc4owkQqxMV8kg4Yvhaw/" crossorigin="anonymous">

  <link rel="stylesheet" href="css/style.css">

  <link rel="shortcut icon" href="<?php echo $favicon;?>">
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a href="#" class="nav-link"><span class="badge badge-primary ml-1"><b><?php echo $website;?></b></span></a>
       
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
            <a href="#" class="nav-link">Schedule <span class="badge badge-primary ml-1">New</span></a>
          </li>
          
        </ul>
        <ul class="navbar-nav navbar-nav-right">
         
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count bg-success">4</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <a class="dropdown-item py-3">
                <p class="mb-0 font-weight-medium float-left">You have 4 new notifications
                </p>
                <span class="badge badge-pill badge-inverse-info float-right">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-inverse-success">
                    <i class="mdi mdi-alert-circle-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal text-dark mb-1">Application Error</h6>
                  <p class="font-weight-light small-text mb-0">
                    Just now
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-inverse-warning">
                    <i class="mdi mdi-comment-text-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
                  <p class="font-weight-light small-text mb-0">
                    Private message
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-inverse-info">
                    <i class="mdi mdi-email-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
                  <p class="font-weight-light small-text mb-0">
                    2 days ago
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block color-setting">
            <a class="nav-link" href="#">
              <i class="mdi mdi-tune"></i>
            </a>
          </li>
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="mr-3">Hello, <?php echo $username; ?> !</span><img class="img-xs rounded-circle" img src="<?php echo $profile_img; ?>" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <a class="dropdown-item mt-2" href="support.php">
                Support
              </a>
              <a class="dropdown-item" href="freegenerator.php">
                Free Generator
              </a>
              <a class="dropdown-item mt-2" href="generator.php">
                Generator
              </a>
              <a class="dropdown-item" href="my-generator.php">
                Profile
              </a>
              <a class="dropdown-item" href="lib/logout.php">
                Sign Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close mdi mdi-close"></i>
          <div class="d-flex align-items-center justify-content-between border-bottom">
            <p class="settings-heading font-weight-bold border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Template Skins</p>
          </div>
          <div class="sidebar-bg-options selected" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <div class="sidebar-bg-options" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <p class="settings-heading font-weight-bold mt-2">Header Skins</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles primary"></div>
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles pink"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close mdi mdi-close"></i>
        <div class="d-flex align-items-center justify-content-between border-bottom">
          <p class="settings-heading font-weight-bold border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
        </div>
        <ul class="chat-list">
          <li class="list active">
            <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Thomas Douglas</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">19 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
            <div class="info">
              <div class="wrapper d-flex">
                <p>Catherine</p>
              </div>
              <p>Away</p>
            </div>
            <div class="badge badge-success badge-pill my-auto mx-2">4</div>
            <small class="text-muted my-auto">23 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Daniel Russell</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">14 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
            <div class="info">
              <p>James Richardson</p>
              <p>Away</p>
            </div>
            <small class="text-muted my-auto">2 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Madeline Kennedy</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">5 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Sarah Graves</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">47 min</small>
          </li>
        </ul>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="profile-image"> <img src="<?php echo $profile_img; ?>" alt="image"/> <span class="online-status online"></span> </div>
              <div class="profile-name">
                <p class="name"><?php echo $username; ?></p>
                <p class="designation"><?php echo $level; ?></p>
              </div>
              <div class="notification-panel mt-4">
                <span><i class="mdi mdi-settings"></i></span>
                <span class="count-wrapper"><i class="mdi mdi-bell"></i><span class="count top-right bg-warning">4</span></span>
                <span><i class="mdi mdi-email"></i></span>
              </div>
            </div>
          </li>
          <li class="nav-item"> <a class="nav-link" href="index.php"> <img class="menu-icon" src="images/menu_icons/03.png" alt="menu icon"> <span class="menu-title">Dashboard</span></a> </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts"> <img class="menu-icon" src="images/menu_icons/09.png" alt="menu icon"> <span class="menu-title">Tools</span><i class="menu-arrow"></i></a>
            <div class="collapse" id="page-layouts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="generator.php">Generator</a></li>
                <li class="nav-item"> <a class="nav-link" href="privategenerator.php">Private Generator</a></li>
                <li class="nav-item"> <a class="nav-link" href="freegenerator.php">Free Generator</a></li>
                <li class="nav-item"> <a class="nav-link" href="generationhistory.php">Generator History</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item"> <a class="nav-link" href="purchase.php"> <img class="menu-icon" src="images/menu_icons/07.png" alt="menu icon"> <span class="menu-title">Purchase</span> </a> </li>
          
          <li class="nav-item"> <a class="nav-link" href="support.php"> <img class="menu-icon" src="images/menu_icons/13.png" alt="menu icon"> <span class="menu-title">Support</span> </a> </li>
          
          <li class="nav-item"> <a class="nav-link" href="communitychat.php" target="blank"> <img class="menu-icon" src="images/menu_icons/20.png" alt="menu icon"> <span class="menu-title">Community Chat</span> </a> </li>
          <li class="nav-item"> <a class="nav-link" href="communitychat.php" target="blank"> <img class="menu-icon" src="images/menu_icons/20.png" alt="menu icon"> <span class="menu-title">User Posts</span> </a> </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth"> <img class="menu-icon" src="images/menu_icons/01.png" alt="menu icon"> <span class="menu-title">Account</span><i class="menu-arrow"></i></a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="my-profile.php"> Profile </a></li>
                <li class="nav-item"> <a class="nav-link" href="loginlogs.php"> Login Logs </a></li>
                <li class="nav-item"> <a class="nav-link" href="generationhistory.php">Generator History</a></li>
               
                <li class="nav-item"> <a class="nav-link" href="lib/logout.php"> Logout </a></li>
              </ul>
            </div>
          </li>
          
          <li class="nav-item"> <a class="nav-link" href="accounts.php"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Accounts List</span> </a> </li>
          <li class="nav-item">
            <div class="sidebar-sticker">
              <div class="d-flex align-items-center text-primary">
                <h6 class="mb-1">Need Help</h6><i class="mdi ml-2 mdi-bell-ring-outline"></i>
              </div>
              <a class="d-block text-gray my-2" href="https://carl0.ml">www.carl0.ml</a>
              <a class="d-block" href="https://steamcommunity.com/id/carlohera">Contact</a>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fas fa-user-astronaut text-success icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Users</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $totalusers;?></b></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fab fa-bitcoin text-primary icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Paid Users</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $activesubscriptions;?></b></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fas fa-sync text-danger icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Generated</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $generated;?></b></a></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fas fa-crosshairs text-info icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Accounts</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $totalalts;?></b></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
             <div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						
              <div class="card">
                <div class="card-body">
     
		 <h4 class="card-title">Edit Or Delete News</h4>
								<form action="admin-news.php" method="POST">
									<textarea name="addnews" class="form-control" rows="3" placeholder="Type your news here..."></textarea>
									<button type="submit" class="btn btn-info btn-block">Add News Message</button>
								</form>
								
								<?php
								$result = mysqli_query($con, "SELECT * FROM `news` ORDER BY `date` DESC") or die(mysqli_error());
								while ($row = mysqli_fetch_assoc($result)) {
									echo '
								                  	<hr>
                  <p class="card-description">
														  <h4><a href="#">'.$row['writer'].' </a>&nbsp <small>'.$row['date'].'</small> <a href="admin-news.php?delete=' . $row['id'] . '" class="pull-right"><i class="fas fa-times-circle"></i></a>&nbsp<a class="pull-right" data-toggle="modal" href="#edit" data-message="'.$row['message'].'" data-newsid="'.$row['id'].'"><i class="fas fa-users-cog"></i></a></h4>
														  <p>'.$row['message'].'</p><hr></p>

									';
								}
								?>
						  </div>
					 
				  </div></div>
				  </div>													  </div>
												  
											
										  </div> </div>
										  </div>
									
					  <!-- Modal -->
					  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-sm">
							  <div class="modal-content">
								  <div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									  <h4 class="modal-title">Edit News Message</h4>
								  </div>
								  <div class="modal-body">
								   <form action="admin-news.php" method="POST">
									<input type="hidden" name="newsid">
									<textarea name="editmessage" class="form-control" rows="5" placeholder="Type a message here.."></textarea>
								  
								  <div class="modal-footer">
									<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
									<button class="btn btn-warning" type="submit"> Update</button>
								  </div>
								   </form>
							  </div>
						  </div>
					  </div>
					  <!-- modal -->
		  
				  </div>
              </div>

          

	
<?php 
				if($_GET['error'] == "no-admin"){
					echo '
						<div class="modal fade" id="error" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top: 15%; overflow-y: visible; display: none;">
							<div class="modal-dialog modal-sm">
								<div class="modal-content panel-warning">
									<div class="modal-header panel-heading">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<center><h3 style="margin:0;"><i class="icon-warning-sign"></i> Error!</h3></center>
									</div>
									<div class="modal-body">
										<center>
											<strong>You must be an admin to do that.</strong>
										</center>
									</div>
								</div>
							</div>
						</div>
					';
				}
			?>
                <div class="clearfix"></div>
    
     	<div class="clearfix"> </div>
			</div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a href="http://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
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
	<script>
	<script>
		$('#editgenerator').on('show.bs.modal', function(e) {
			var generator = $(e.relatedTarget).data('generator');
			var link = $(e.relatedTarget).data('link');
			var about = $(e.relatedTarget).data('about');
			var stock = $(e.relatedTarget).data('stock');
			var stockcolor = $(e.relatedTarget).data('stockcolor');
			var generatorid = $(e.relatedTarget).data('generatorid');
			$(e.currentTarget).find('input[name="editgenerator"]').val(generator);
			$(e.currentTarget).find('input[name="editlink"]').val(link);
			$(e.currentTarget).find('textarea[name="editabout"]').val(about);
			$(e.currentTarget).find('select[name="editstock"]').val(stock);
			$(e.currentTarget).find('select[name="editstockcolor"]').val(stockcolor);
			$(e.currentTarget).find('input[name="generatorid"]').val(generatorid);
		});
		
		$('#editpackage').on('show.bs.modal', function(e) {
			var package = $(e.relatedTarget).data('package');
			var packageid = $(e.relatedTarget).data('packageid');
			var price = $(e.relatedTarget).data('price');
			var length = $(e.relatedTarget).data('length');
			var accounts = $(e.relatedTarget).data('accounts');
			var generator = $(e.relatedTarget).data('generator');
			$(e.currentTarget).find('input[name="editpackage"]').val(package);
			$(e.currentTarget).find('input[name="packageid"]').val(packageid);
			$(e.currentTarget).find('input[name="editprice"]').val(price);
			$(e.currentTarget).find('input[name="editmax"]').val(accounts);
		});
	</script>
	<script>
	$('#edit').on('show.bs.modal', function(e) {
		var newsid = $(e.relatedTarget).data('newsid');
		var message = $(e.relatedTarget).data('message');
		$(e.currentTarget).find('input[name="newsid"]').val(newsid);
		$(e.currentTarget).find('textarea[name="editmessage"]').val(message);
	});
	</script>

  </body>
</html>
