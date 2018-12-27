<?php
if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}
include "inc/header.php";
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

<style>
td {
 font-weight:bold;color:#6991f7;
}</style><div class="row">
         <div class="col-md-8 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">News & Updates</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table">
                      <table id="sortable-table-2" class="table table-striped">
                        <thead>
                            <tbody>
								<?php
									$result = mysqli_query($con, "SELECT * FROM `news` ORDER BY `id` DESC");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '
										<tr>
											<td>
												<i class="fas fa-diagnoses text-danger"></i>
											</td>
											<td><b>'.$row['message'].'</b></td>
											<td><b> '.$row['date'].'</b></td>
											<td><b>Posted By '.$row['writer'].' - </b></td>
											<td><b>Date: '.$row['date'].' </b></td>
										</tr>
									';
									}
								?>
                                </tbody></thead>
                  </table>
                </div>
              </div>	</div>	</div>
		 <div class="col-md-4 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">News & Updates</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12">
                      <table id="sortable-table-2" class="table table-striped">
								<center><img src="<?php echo $profile_img; ?>" class="img-lg rounded-circle mb-2" alt="profile image" height="80px" width="80px"/>
								
										<h4><b><?php echo $username; ?></b></h4>
								
									<p class="mt-4 card-text">
										<?php echo $bio; ?>
									</p>
									 <p class="text-muted font-13"><strong>User ID: </strong><span class="m-l-15"><?php echo $_SESSION['id']; ?></span></p>
                                                
                                                 <p class="text-muted font-13"><strong>You're A </strong> <span class="m-l-15">
					<?php
					if (($_SESSION['rank']) == "1") {
					echo 'Customer';}?>
					<?php
					if (($_SESSION['rank']) == "4") {
					echo 'Cracker';}?>
					<?php
					if (($_SESSION['rank']) == "5") {
					echo 'Admin';}?>
					
												 </span></p>
                                                
                                                <p class="text-muted font-13"><strong>Username:</strong> <span class="m-l-15"><?php echo $username;?></span></p>

                                                <p class="text-muted font-13"><strong>Email:</strong><span class="m-l-15"> <?php echo $_SESSION['email']; ?></span></p>
									<a class="btn btn-info btn-md mt-3 mb-4" href="my-profile.php"> My Profile</a>
									<a class="btn btn-danger btn-md mt-3 mb-4" href="support.php"> Support</a>
									</center></table>
										</div>
									</div>
								</div>
							</div>
							</div>
								</div>
       <?php include("noob/footer.php"); ?>
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
	$('#custom-modal-width').on('show.bs.modal', function(e) {
		var newsid = $(e.relatedTarget).data('newsid');
		var title = $(e.relatedTarget).data('title');
		var message = $(e.relatedTarget).data('message');
		$(e.currentTarget).find('input[name="newsid"]').val(newsid);
		$(e.currentTarget).find('input[name="edittitle"]').val(title);
		$(e.currentTarget).find('textarea[name="editmessage"]').val(message);
	});
	</script>
    </body>
</html>