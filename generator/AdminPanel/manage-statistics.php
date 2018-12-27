<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}

if ($_GET['action'] == "resetall"){
	mysqli_query($con, "TRUNCATE TABLE `statistics`") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-statistics.php");
		</script>
	';
}

if (isset($_GET['reset'])){
	$id = mysqli_real_escape_string($con, $_GET['reset']);
	
	$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `id` = '$id'") or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		$user = $row['username'];
	}
	echo $user;
	mysqli_query($con, "DELETE FROM `statistics` WHERE `username` = '$user'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-statistics.php");
		</script>
	';
}

$generatedtoday = 0;

$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `date` = '$date'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$generatedtoday = $generatedtoday + $row['generated'];
}

$profit = 0;

$result = mysqli_query($con, "SELECT * FROM `subscriptions`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$profit = $profit + $row['price'];
}

$profittoday = 0;

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `date` = '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$profittoday = $profittoday + $row['price'];
}

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
$activesubscriptions = mysqli_num_rows($result);

$result = mysqli_query($con, "SELECT * FROM `users`") or die(mysqli_error($con));
$totalusers = mysqli_num_rows($result);

if (isset($_POST['website']) & isset($_POST['paypal'])){
	$website = mysqli_real_escape_string($con, $_POST['website']);
	$paypal = mysqli_real_escape_string($con, $_POST['paypal']);
	$footer = mysqli_real_escape_string($con, $_POST['footer']);
	$favicon = mysqli_real_escape_string($con, $_POST['favicon']);

	mysqli_query($con, "UPDATE `settings` SET `website` = '$website'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `settings` SET `paypal` = '$paypal'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `settings` SET `footer` = '$footer'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `settings` SET `favicon` = '$favicon'") or die(mysqli_error($con));

}

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
                  <center><h4 class="card-title">News & Updates</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
									<div id="collapse">

										<input id="filter" type="text" class="form-control" placeholder="Filter..">
									  <thead>
									  <tr>
									      <th><i class="fa fa-user"></i> Username</th>
										  <th><i class="fa fa-repeat"></i> Total Generated</th>
										  <th><i class="fa fa-calendar"></i> Generated Today</th>
										  <th></th>
									  </tr>
									  </thead>
									  <tbody class="searchable">
										<?php
										$result = mysqli_query($con, "SELECT * FROM `statistics` GROUP BY `username`") or die(mysqli_error($con));
										while ($row = mysqli_fetch_array($result)) {
											$usertotalgenerated = 0;
											$result2 = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$row[username]'") or die(mysqli_error($con));
											while ($row2 = mysqli_fetch_array($result2)) {
												$usertotalgenerated = $usertotalgenerated + $row2['generated'];
											}
											$result3 = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$row[username]' AND `date` = '$date'") or die(mysqli_error($con));
											if(mysqli_num_rows($result3) < 1){
												$usergeneratedtoday = "0";
											}else{
												while ($row3 = mysqli_fetch_array($result3)) {
													$usergeneratedtoday = $row3['generated'];
												}
											}
											echo '<tr>
											  <td><a href="#">' . $row['username'] . '</a></td>
											  <td>'.$usertotalgenerated.' </td>
											  <td>'.$usergeneratedtoday.' </td>
											  <td><a class="btn btn-info btn-xs" href="manage-statistics.php?reset='.$row['id'].'"><i class="fa fa-remove-circle "> Reset</i></a></td>
											</tr>';
										}
										?>
									  </tbody>
								  </table>
						
								    
			</div>
		</div>	</div>
	</div>

  
 <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Stats</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                  <li><a href="#"> <strong><i class="fa fa-repeat"></i></strong>&nbsp Total Generated<span class="label label-primary pull-right r-activity"><?php echo $generated;?></span></a></li>
                                   <legend></legend>
                                  <li><a href="#"> <strong><i class="fa fa-calendar"></i></strong>&nbsp Generated Today<span class="label label-warning pull-right r-activity"><?php echo $generatedtoday;?></span></a></li></br>
								  <legend></legend>
								  <a class="btn btn-danger btn-block" href="manage-statistics.php?action=resetall"><i class="fa fa-remove-circle "> Reset All</i></a>
						
								    
			</div>
		</div>
	</div></div>
                   


            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

<?php include("noob/footer.php"); ?>