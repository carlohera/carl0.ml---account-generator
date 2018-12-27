<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}

if (isset($_GET['delete'])){
	$id = mysqli_real_escape_string($con, $_GET['delete']);
	mysqli_query($con, "UPDATE `subscriptions` SET `active` = '0' WHERE `id` = '$id'") or die(mysqli_error($con));
	echo ' 
		<script>
			window.history.replaceState("object or string", "Title", "manage-subscriptions.php");
		</script>
	';
}

if (isset($_POST['subscriptionid']) && isset($_POST['editpackage']) && isset($_POST['editexpires'])){
	$id = mysqli_real_escape_string($con, $_POST['subscriptionid']);
	$package = mysqli_real_escape_string($con, $_POST['editpackage']);
	$expires = mysqli_real_escape_string($con, $_POST['editexpires']);
	mysqli_query($con, "UPDATE `subscriptions` SET `package` = '$package' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `subscriptions` SET `expires` = '$expires' WHERE `id` = '$id'") or die(mysqli_error($con));
}

if (isset($_POST['addsubscription']) && isset($_POST['package'])){
	$user = mysqli_real_escape_string($con, $_POST['addsubscription']);
	$package = mysqli_real_escape_string($con, $_POST['package']);

	$result = mysqli_query($con,"SELECT * FROM `packages` WHERE `id` = '$package'");
	while ($row = mysqli_fetch_array($result)) 
	{
		$length = $row['length'];
	}

	$today = time();

	if($length == "Lifetime"){
		$expires = strtotime("100 years", $today);
	}elseif($length == "1 Day"){
		$expires = strtotime("+1 day", $today);
	}elseif($length == "3 Days"){
		$expires = strtotime("+3 days", $today);
	}elseif($length == "1 Week"){
		$expires = strtotime("+1 week", $today);
	}elseif($length == "1 Month"){
		$expires = strtotime("+1 month", $today);
	}elseif($length == "2 Months"){
		$expires = strtotime("+2 months", $today);
	}elseif($length == "3 Months"){
		$expires = strtotime("+3 months", $today);
	}elseif($length == "4 Months"){
		$expires = strtotime("+4 months", $today);
	}elseif($length == "5 Months"){
		$expires = strtotime("+5 months", $today);
	}elseif($length == "6 Months"){
		$expires = strtotime("+6 months", $today);
	}elseif($length == "7 Months"){
		$expires = strtotime("+7 months", $today);
	}elseif($length == "8 Months"){
		$expires = strtotime("+8 months", $today);
	}elseif($length == "9 Months"){
		$expires = strtotime("+9 months", $today);
	}elseif($length == "10 Months"){
		$expires = strtotime("+10 months", $today);
	}elseif($length == "11 Months"){
		$expires = strtotime("+11 months", $today);
	}elseif($length == "12 Months"){
		$expires = strtotime("+12 months", $today);
	}else{
	}

	$expires = date('Y-m-d', $expires);
	mysqli_query($con, "INSERT INTO `subscriptions` (`username`, `date`, `price`, `payment`, `package`, `expires`) VALUES ('$user', DATE('$date'), '0.00', 'Gift', '$package', '$expires')") or die(mysqli_error($con));
}

$result = mysqli_query($con, "SELECT * FROM `subscriptions`") or die(mysqli_error($con));
$totalsubscriptions = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
$activesubscriptions = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `expires` < '$date'") or die(mysqli_error($con));
$expiredsubscriptions = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `date` = '$date'") or die(mysqli_error($con));
$todayssubscriptions = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `active` = '0'") or die(mysqli_error($con));
$canceledsubscriptions = mysqli_num_rows($result);
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

?>

<?php include("noob/header.php"); ?>

      <div class="row">
         <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Manage Subscriptions</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
									<div id="collapse">

										<button class="btn btn-primary btn-large btn-block" data-toggle="collapse" data-target="#addsubscription" data-parent="#collapse"><i class="fa fa-plus"></i> Add Subscription</button></br>

										<div id="addsubscription" class="sublinks collapse">
											<legend></legend>
											<form action="manage-subscriptions.php" method="POST">
												<input type="text" name="addsubscription" class="form-control" placeholder="Username"></br>
												<select name="package" class="form-control">
												<?php
													$packagesquery = mysqli_query($con, "SELECT * FROM `packages`") or die(mysqli_error($con));
													while($row = mysqli_fetch_assoc($packagesquery)){
														echo '<option value="'.$row[id].'">'.$row[name].'</option>';
													}
												?>
												</select></br>
												<button type="submit" class="btn btn-primary btn-large btn-block"><i class="fa fa-plus"></i> Add Subscription</button>
											</form>
										</div>
										<legend></legend>
										<input id="filter" type="text" class="form-control" placeholder="Filter..">
									  <thead>
									  <tr>
										  <th><i class="fa fa-user"></i> Username</th>
										  <th><i class="fa fa-tag"></i> Package</th>
										  <th><i class="fa fa-calendar"></i> Expires</th>
										  <th></th>
										  <th></th>
									  </tr>
									  </thead>
									  <tbody class="searchable">
										<?php
										$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
										while ($row = mysqli_fetch_array($result)) {
											echo'<tr><td><a href="#">'.$row['username'].'</a></td>';
											$packagequery = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$row[package]'") or die(mysqli_error($con));
											while ($packageinfo = mysqli_fetch_array($packagequery)) {
												echo '<td>' . $packageinfo['name'] . '</td>';
												$package = $packageinfo['name'];
											}
											echo '
												  <td>'.$row['expires'].'</td>
												  <td><a class="btn btn-success btn-xs" data-toggle="modal" href="#info" data-username="'.$row['username'].'" data-package="'.$package.'" data-price="'.$row['price'].'" data-payment="'.$row['payment'].'" data-date="'.$row['date'].'" data-expires="'.$row['expires'].'" data-txn="'.$row['txn'].'"><i class="fa fa-info"></i>&nbsp More Info</a></td>
												  <td>
													  <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit" data-username="'.$row['username'].'" data-package="'.$row['package'].'" data-expires="'.$row['expires'].'" data-subscriptionid="'.$row['id'].'"><i class="mdi mdi-settings"></i></a>
													  <a class="btn btn-danger btn-xs" href="manage-subscriptions.php?delete=' . $row['id'] . '"><i class="fa fa-trash "></i></a>
												  </td>
											  </tr>
											';
										}
										?>
									  </tbody>
								  </table>
			</div>
		</div>
	</div>
                   
                   
                   
                   <!-- Modal -->
		  <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						  <h4 class="modal-title">Subscription Info</h4>
					  </div>
					  <div class="modal-body">
						<div class="form-group">
						  <label for="username">Username</label>
						  <input type="text" class="form-control" name="username" disabled>
						</div>
						<div class="form-group">
						  <label for="package">Package</label>
						  <input type="text" class="form-control" name="package" disabled>
						</div>
						<div class="form-group">
						  <label for="price">Price</label>
						  <input type="text" class="form-control" name="price" disabled>
						</div>
						<div class="form-group">
						  <label for="payment">Payment Method</label>
						  <input type="text" class="form-control" name="payment" disabled>
                        </div>
						<div class="form-group">
						  <label for="date">Date</label>
						  <input type="date" class="form-control" name="date" disabled>
                        </div>
						<div class="form-group">
						  <label for="expires">Expires</label>
						  <input type="date" class="form-control" name="expires" disabled>
                        </div>
						<div class="form-group">
						  <label for="txn">Transaction ID</label>
						  <input type="text" class="form-control" name="txn" disabled>
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
						  <h4 class="modal-title">Edit Subscription</h4>
					  </div>
					  <div class="modal-body">
					   <form action="manage-subscriptions.php" method="POST">
					    <input type="hidden" name="subscriptionid">
						<div class="form-group">
						  <label>Username</label>
						  <input type="text" class="form-control" name="editusername" disabled>
						</div>
						<div class="form-group">
						  <label>Package</label>
						  <select class="form-control" name="editpackage">
							<?php
								$packagesquery = mysqli_query($con, "SELECT * FROM `packages`") or die(mysqli_error($con));
								while($row = mysqli_fetch_assoc($packagesquery)){
									echo '<option value="'.$row[id].'">'.$row[name].'</option>';
								}
							?>
						  </select>
						</div>
						<div class="form-group">
						  <label>Expires</label>
						  <input type="date" class="form-control" name="editexpires">
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
		  
                   
                   		  
	            
                   
                   
                   
                   
                   
                   
                   
                        </div><!-- container -->


                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->
<?php include("noob/footer.php"); ?>
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
			var package = $(e.relatedTarget).data('package');
			var price = $(e.relatedTarget).data('price');
			var payment = $(e.relatedTarget).data('payment');
			var date = $(e.relatedTarget).data('date');
			var expires = $(e.relatedTarget).data('expires');
			var txn = $(e.relatedTarget).data('txn');
			$(e.currentTarget).find('input[name="username"]').val(username);
			$(e.currentTarget).find('input[name="package"]').val(package);
			$(e.currentTarget).find('input[name="price"]').val(price);
			$(e.currentTarget).find('input[name="payment"]').val(payment);
			$(e.currentTarget).find('input[name="date"]').val(date);
			$(e.currentTarget).find('input[name="expires"]').val(expires);
			$(e.currentTarget).find('input[name="txn"]').val(txn);
		});
		
		$('#edit').on('show.bs.modal', function(e) {
			var editusername = $(e.relatedTarget).data('username');
			var editexpires = $(e.relatedTarget).data('expires');
			var subscriptionid = $(e.relatedTarget).data('subscriptionid');
			var editpackage = $(e.relatedTarget).data('package');
			$(e.currentTarget).find('input[name="editusername"]').val(editusername);
			$(e.currentTarget).find('input[name="editexpires"]').val(editexpires);
			$(e.currentTarget).find('input[name="subscriptionid"]').val(subscriptionid);
		});
	</script>
    </body>

</html>