<?php

require_once('pieces/header.php');
	require_once('pieces/inc.php');
include "inc/header.php";


if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}

if (isset($_GET['delete'])){
	$id = mysqli_real_escape_string($con, $_GET['delete']);
	mysqli_query($con, "DELETE FROM `users` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-users.php");
		</script>
	';
}

if (isset($_POST['adduser']) && isset($_POST['password']) && isset($_POST['rank'])){
	$username = mysqli_real_escape_string($con, $_POST['adduser']);
	$password = mysqli_real_escape_string($con, md5($_POST['password']));
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$rank = mysqli_real_escape_string($con, $_POST['rank']);
	mysqli_query($con, "INSERT INTO `users` (`username`, `password`, `email`, `rank`, `date`) VALUES ('$username', '$password', '$email', '$rank', DATE('$date'))") or die(mysqli_error($con));
}

if (isset($_GET['ban'])){
	$id = mysqli_real_escape_string($con, $_GET['ban']);
	mysqli_query($con, "UPDATE `users` SET `status` = '0' WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-users.php");
		</script>
	';
}

if (isset($_POST['userid']) && isset($_POST['editrank'])){
	$id = mysqli_real_escape_string($con, $_POST['userid']);
	$rank = mysqli_real_escape_string($con, $_POST['editrank']);
	mysqli_query($con, "UPDATE `users` SET `rank` = '$rank' WHERE `id` = '$id'") or die(mysqli_error($con));
	if(!empty($_POST['editpassword'])){
		$password = mysqli_real_escape_string($con, md5($_POST['editpassword']));
		mysqli_query($con, "UPDATE `users` SET `password` = '$password' WHERE `id` = '$id'") or die(mysqli_error($con));
	}
}

$result = mysqli_query($con, "SELECT * FROM `users`") or die(mysqli_error($con));
$totalusers = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `users` WHERE `status` = '1'") or die(mysqli_error($con));
$activeusers = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `users` WHERE `status` = '0'") or die(mysqli_error($con));
$bannedusers = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `users` WHERE `date` = '$date'") or die(mysqli_error($con));
$todaysusers = mysqli_num_rows($result);
	
?>
<?php include("noob/header.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="24/7">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="<?php echo $favicon;?>">

    <title><?php echo $website;?> - Administration</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
	<!--external css-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
           
            <!--logo end-->
	
                    <!-- inbox dropdown end -->

                    <!-- user login dropdown end -->
               
                <!--user info end-->
            
        </header>
      <!--header end-->
      <!--sidebar start-->

      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">

              <div class="row">
				  <div class="col-lg-9">
					  <section class="panel">
						  <div class="panel-body">
							  <div class="task-thumb-details">
								  <h1>Manage Users</h1>
							  </div>
							  <legend></legend>
								<section class="panel">
								  <table class="table table-striped table-advance table-hover">
								  
									<div id="collapse">

										<button class="btn btn-info btn-large btn-block" data-toggle="collapse" data-target="#adduser" data-parent="#collapse"><i class="icon-plus"></i> Add User</button></br>

										<div id="adduser" class="collapse">
											<legend></legend>
											<form action="manage-users.php" method="POST">
												<input type="text" name="adduser" class="form-control" placeholder="Username"></br>
												<input type="password" name="password" class="form-control" placeholder="Password"></br>
												<input type="email" name="email" class="form-control" placeholder="Email"></br>
												<select name="rank" class="form-control">
													<option value="1">Member</option>
													<option value="5">Admin</option>
												</select></br>
												<button type="submit" class="btn btn-primary btn-large btn-block"><i class="icon-plus"></i> Add User</button>
											</form>
										</div>
										<legend></legend>
										<input id="filter" type="text" class="form-control" placeholder="Filter..">
									  <thead>
									  <tr>
										  <th><i class="icon-user"></i> Username</th>
										  <th><i class="icon-calendar"></i> Date</th>
										  <th><i class="icon-globe"></i> IP</th>
										  <th><i class="icon-star"></i> Rank</th>
										  <th></th>
										  <th></th>
										  <th></th>
									  </tr>
									  </thead>
									  <tbody class="searchable">
										<?php
										$result = mysqli_query($con, "SELECT * FROM `users` WHERE `status` = '1'") or die(mysqli_error($con));
										while ($row = mysqli_fetch_array($result)) {
											echo'<tr>
													<td><a href="#">'.$row['username'].'</a></td>
													<td>'.$row['date'].'</td>
													<td>'.$row['ip'].'</td>';
													if($row['rank'] == "1"){echo '<td>Member</td>';}elseif($row['rank'] == "5"){echo '<td>Admin</td>';}else{echo '<td></td>';}
											echo '
													<td><a class="btn btn-success btn-xs" data-toggle="modal" href="#info" data-username="'.$row['username'].'" data-date="'.$row['date'].'" data-rank="'.$row['rank'].'"><i class="icon-info"></i>&nbsp More Info</a></td>
													
													<td>
														<a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit" data-username="'.$row['username'].'" data-rank="'.$row['rank'].'" data-userid="'.$row['id'].'"><i class="fas fa-user-edit"></i></a>
														
														<a class="btn btn-warning btn-xs" href="manage-users.php?ban=' . $row['id'] . '"><i class="fas fa-ban" size="9x"></i></a>
														<a class="btn btn-danger btn-xs" href="manage-users.php?delete=' . $row['id'] . '"><i class="fas fa-trash-alt"></i></a>
													</td>
												 </tr>
											';
										}
										?>
									  </tbody>
								  </table>
							  </section>
						  </div>
					  </section>
				  </div>
				  <div class="col-lg-3">
					  <section class="panel">
						  <div class="panel-body">
							  <div class="task-thumb-details">
								  <h1>Subscription Statistics</h1>
							  </div>
							  <legend></legend>
								<ul class="nav nav-pills nav-stacked">
                                  <li><a href="#"> <strong><i class="icon-user"></i></strong>&nbsp Total Users: <span class="label label-primary pull-right r-activity"><?php echo $totalusers;?></span></a></li>
                              </br>
                                  <li><a href="#"> <strong><i class="icon-ok"></i></strong>&nbsp Active Users: <span class="label label-warning pull-right r-activity"><?php echo $activeusers;?></span></a></li>
                                  </br>
								  <li><a href="#"> <strong><i class="icon-remove"></i></strong>&nbsp Banned Users: <span class="label label-success pull-right r-activity"><?php echo $bannedusers;?></span></a></li>
								  </br></br>
								  <li><a href="#"> <strong><i class="icon-calendar"></i></strong>&nbsp Today's Users: <span class="label label-info pull-right r-activity"><?php echo $todaysusers;?></span></a></li>
								  </br>
								</ul>
						  </div>
					  </section>
				  </div>
              </div>

          </section>
		  
		  <!-- Modal -->
		  <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						  <h4 class="modal-title">User Info</h4>
					  </div>
					  <div class="modal-body">
						<div class="form-group">
						  <label>Username</label>
						  <input type="text" class="form-control" name="username" disabled>
						</div>
						<div class="form-group">
						  <label>Date</label>
						  <input type="date" class="form-control" name="date" disabled>
						</div>
						<div class="form-group">
						  <label>Rank</label>
						  <input type="text" class="form-control" name="rank" disabled>
						</div>
					  </div>
				  </div>
			  </div>
		  </div>
		  <!-- modal -->
		  
		  <!-- Modal -->
		  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						  <h4 class="modal-title">Edit User</h4>
					  </div>
					  <div class="modal-body">
					   <form action="manage-users.php" method="POST">
					    <input type="hidden" name="userid">
						<div class="form-group">
						  <label>Username</label>
						  <input type="text" class="form-control" name="editusername" disabled>
						</div>
						<div class="form-group">
						  <label>Password</label>
						  <input type="password" class="form-control" name="editpassword">
						</div>
						<div class="form-group">
						  <label>Rank</label>
						  <select class="form-control" name="editrank">
							<option value="1">Member</option>
							<option value="5">Admin</option>
						  </select>
						</div>
					  </div>
					  <div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
						<button class="btn btn-warning" type="submit"> Update</button>
                      </div>
					   </form>
				  </div>
			  </div>
		  </div>
		  <!-- modal -->
		  
      </section>
      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              <?php echo $footer;?>
              <a href="#" class="go-top">
                  <i class="icon-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/jquery.customSelect.min.js" ></script>
    <script src="js/respond.min.js" ></script>
	
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
	
	<script>
		$(document).ready(function () {

			(function ($) {

				$('#filter').keyup(function () {

					var rex = new RegExp($(this).val(), 'i');
					$('.searchable tr').hide();
					$('.searchable tr').filter(function () {
						return rex.test($(this).text());
					}).show();

				})

			}(jQuery));

		});
		
		$('#info').on('show.bs.modal', function(e) {
			var username = $(e.relatedTarget).data('username');
			var date = $(e.relatedTarget).data('date');
			var rank = $(e.relatedTarget).data('rank');
			$(e.currentTarget).find('input[name="username"]').val(username);
			$(e.currentTarget).find('input[name="date"]').val(date);
			$(e.currentTarget).find('input[name="rank"]').val(rank);
		});
		
		$('#edit').on('show.bs.modal', function(e) {
			var username = $(e.relatedTarget).data('username');
			var userid = $(e.relatedTarget).data('userid');
			var rank = $(e.relatedTarget).data('rank');
			$(e.currentTarget).find('input[name="editusername"]').val(username);
			$(e.currentTarget).find('input[name="userid"]').val(userid);
		});
	
	</script>

  </body>
</html>
