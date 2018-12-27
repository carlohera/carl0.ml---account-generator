<?php
	require_once('pieces/header.php');
	require_once('pieces/inc.php');
include "inc/header.php";
include "../inc/connection.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}

	if(isset($_POST['generate'])) {
		$selector = $_POST['selector'];
		
		$serv = mysqli_query($sql, 'SELECT * FROM dumps WHERE DumpCategory = "'.$selector.'" ORDER BY RAND() LIMIT 1');
		$acc = mysqli_fetch_array($serv);
		
		$alt = $acc['DumpAlt'];
	}
	
	$serv = mysqli_query($sql, 'SELECT * FROM dumps ORDER BY DumpID');

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

          		<?php 
		if (isset($_POST['sent']))
		{
			$cpassword = $_POST['first_last_name'];
			if (!empty($first_last_name))
			{
				if ($npassword == $rpassword)
				{
					$newpassword = md5($npassword);
						if ($md5password == md5($cpassword)) {
				
    							echo '
					    
						
						';
						}
						else {
							echo '

						';
						}
					}
				else
				{
					echo '

					';
				}
			}
			else
			{
				echo '
		
				
				   <div class="">
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <strong>Success!</strong> Your generator settings have been successfully updated
                                                </div>
				';
			}
		}
		?>


                           <div class="row">
         <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Settings</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                                <?php
								$accountsquery = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));
								while($row = mysqli_fetch_assoc($accountsquery)){
									echo '
								 <form class="form-horizontal" action="settings.php" method="POST">
										  <div class="form-group">
											  <label for="website" class="col-lg-2 col-sm-2 control-label">Website Name</label>
											  <div class="col-lg-12">
												  <input type="text" class="form-control" name="website" placeholder="Website Name" value="'.$row['website'].'">
											  </div>
										  </div>
										  <div class="form-group">
											  <label for="paypal" class="col-lg-2 col-sm-2 control-label">Paypal</label>
											  <div class="col-lg-12">
												  <input type="email" class="form-control" name="paypal" placeholder="name@domain.com" value="'.$row['paypal'].'">
											  </div>
										  </div>
										  <div class="form-group">
											  <label for="bitcoin" class="col-lg-2 col-sm-2 control-label">Bitcoin</label>
											  <div class="col-lg-12">
												  <input type="text" class="form-control" name="bitcoin" placeholder="Bitcoin is not enabled." disabled>
											  </div>
										  </div>
										  <div class="form-group">
											  <label for="footer" class="col-lg-2 col-sm-2 control-label">Footer</label>
											  <div class="col-lg-12">
												  <input type="text" class="form-control" name="footer" placeholder="© 2014-2015 | Name Inc."  value="'.$row['footer'].'">
											  </div>
										  </div>
										  <div class="form-group">
											  <label for="favicon" class="col-lg-2 col-sm-2 control-label">Favicon</label>
											  <div class="col-lg-12">
												  <input type="url" class="form-control" name="favicon" placeholder="http://domain.com/image.jpg"  value="'.$row['favicon'].'">
											  </div>
										  </div>
										  <button type="submit" name="sent" class="btn btn-primary btn-large btn-block"><i class="icon-edit"></i> Update Settings</button>
									  </form></div>
                                    </div>
                                </div>
									';
								}
							  ?>
                                        </div>
                                    </div>
                                </div>
</section>
                            </div>
                            <!-- end row -->

                        </div><!-- container -->


             <?php include("noob/footer.php"); ?>
    </body>

</html>
