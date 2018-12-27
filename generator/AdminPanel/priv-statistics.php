<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}

if (isset($_POST['alts']) & isset($_POST['generator'])){
	$id = mysqli_real_escape_string($con, $_POST['generator']);
	$values = htmlspecialchars($_POST['alts']);
	$array = explode("\n", $values);
	foreach($array as $line){
		$line = mysqli_real_escape_string($con, $line);
		if (!empty($line)) {
			mysqli_query($con, "INSERT INTO `privgenerator$id` (`alt`) VALUES ('$line')") or die(mysqli_error($con));
		}
	}
}

if ($_GET['action'] == "resetall"){
	mysqli_query($con, "TRUNCATE TABLE `privstatistics`") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "priv-statistics.php");
		</script>
	';
}

if (isset($_GET['reset'])){
	$id = mysqli_real_escape_string($con, $_GET['reset']);
	
	$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `id` = '$id'") or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		$user = $row['username'];
	}
	echo $user;
	mysqli_query($con, "DELETE FROM `privstatistics` WHERE `username` = '$user'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "priv-statistics.php");
		</script>
	';
}

$privgeneratedtoday = 0;

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `date` = '$date'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$privgeneratedtoday = $privgeneratedtoday + $row['generated'];
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
                  <center><h4 class="card-title">Private Generator Stats</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                       	  <thead>
									  <tr>
										  <th><i class="fa fa-user-circle"></i> Username</th>
										  <th><i class="fa fa-refresh"></i> Total Generated</th>
										  <th><i class="fa fa-calendar"></i> Generated Today</th>
										  <th></th>

									  </tr>
									  </thead>
									  <tbody class="searchable">
										<?php
										$result = mysqli_query($con, "SELECT * FROM `privstatistics` GROUP BY `username`") or die(mysqli_error($con));
										while ($row = mysqli_fetch_array($result)) {
											$privusertotalgenerated = 0;
											$result2 = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$row[username]'") or die(mysqli_error($con));
											while ($row2 = mysqli_fetch_array($result2)) {
												$privusertotalgenerated = $privusertotalgenerated + $row2['generated'];
											}
											$result3 = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$row[username]' AND `date` = '$date'") or die(mysqli_error($con));
											if(mysqli_num_rows($result3) < 1){
												$privusergeneratedtoday = "0";
											}else{
												while ($row3 = mysqli_fetch_array($result3)) {
													$privusergeneratedtoday = $row3['generated'];
												}
											}
											echo '<tr>
											  <td><a href="#">' . $row['username'] . '</a></td>
											  <td>'.$privusertotalgenerated.'</td>
											  <td>'.$privusergeneratedtoday.'</td>
											  <td><a class="btn btn-primary btn-xs" href="priv-statistics.php?reset='.$row['id'].'"><i class="fa fa-remove-circle "> Reset</i></a></td>
											</tr>';
										}
										?>
									  </tbody>
                                    </table>
			</div>
		</div>
	</div>
     
                
                           
            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

<?php include("noob/footer.php"); ?>