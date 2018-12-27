<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}


if (isset($_GET['delete'])){
	$id = sec_tag($con, $_GET['delete']);
	mysqli_query($con, "DELETE FROM `faq` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "/admin-support.php");
		</script>
	';
}

if (isset($_POST['reply']) & isset($_POST['id']) & isset($_POST['first']) & isset($_POST['third']) & isset($_POST['second'])){
	$reply = sec_tag($con, $_POST['reply']);
	$id = sec_tag($con, $_POST['id']);
	$first = sec_tag($con, $_POST['first']);
	$second = sec_tag($con, $_POST['second']);
	$third = sec_tag($con, $_POST['third']);
	$fourth = sec_tag($con, $_POST['fourth']);
	mysqli_query($con, "INSERT INTO `faq` (`from`, `first`, `second`, `third`, `date` , `fourth`) 
	VALUES ('Admin', '$first', '$second', '$third', DATE('$date') , '$fourth')") or die(mysqli_error($con));

}



if (isset($_GET['delete'])){
	$id = sec_tag($con, $_GET['delete']);
	mysqli_query($con, "DELETE FROM `faq` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "/admin-support.php");
		</script>
	';
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
	mysqli_query($con, "DELETE FROM `faq` WHERE `id` = '$id'") or die(mysqli_error($con));

	echo '
		done
	';
}
mysqli_query($con, "SELECT * FROM `tos") or die(mysqli_error($con));
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
   
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Manage Faq</h4>
                 
                  <div class="template-demo">
             
                                                <?php
								$accountsquery = mysqli_query($con, "SELECT * FROM `faq`") or die(mysqli_error($con));
								while($row = mysqli_fetch_assoc($accountsquery)){
									echo '
								 <form class="form-horizontal" action="settings.php" method="POST" rows="3">
										  <div class="form-group">
											  <label for="website" class="col-lg-2 col-sm-2 control-label" >Main Terms</label>
											  <div class="col-lg-12">
												  <input type="text" class="form-control" name="first" placeholder="First" value="'.$row['first'].'">
											  </div>
										  </div>
										  <div class="form-group">
											  <label for="second" class="col-lg-2 col-sm-2 control-label">Second</label>
											  <div class="col-lg-12">
												  <input type="text" class="form-control" name="second" placeholder="Second" value="'.$row['second'].'">
											  </div>
										  </div>
										  <div class="form-group">
											  <label for="third" class="col-lg-2 col-sm-2 control-label">Third</label>
											  <div class="col-lg-12">
												  <input type="text" class="form-control" name="third" value="'.$row['third'].'">
											  </div>
										  </div>
										  <div class="form-group">
											  <label for="fourth" class="col-lg-2 col-sm-2 control-label">fourth</label>
											  <div class="col-lg-12">
												  <input type="text" class="form-control" name="fourth" value="'.$row['fourth'].'">
											  </div>
										  </div>
										  </div>
										
                                <div class="col-lg-12">
                                <br>
                                <button type="submit" name="sent" class="btn btn-primary btn-block"><i class="icon-edit"></i> Update Settings</button>
									  </form></div>
                                    </div>
                                </div>
									';
								}
							  ?>
                                        </div>
                                    </div>
                               


     <?php include("noob/footer.php"); ?>
