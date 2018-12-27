<?php

ob_start();

include 'inc/database.php';

if (!isset($_SESSION)) { 
	session_start(); 
}

function sec_tag($connection, $element){
	$filter_tag = htmlspecialchars(stripcslashes(mysqli_real_escape_string($connection, $element)));
	return $filter_tag;
}


$username = $_SESSION['username'];
$id = $_SESSION['id'];
$date = date("Y-m-d");
$datetime = date("Y-m-d H:i:s");

$result = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
	$website = $row['website'];
	$paypal = $row['paypal'];
	$footer = $row['footer'];
	$favicon = $row['favicon'];
}

$generated = 0;

$result = mysqli_query($con, "SELECT * FROM `statistics`") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$generated = $generated + $row['generated'];
}



$result = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '$id'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$profile_img = $row['profile_img'];
	$level = $row['level'];
	$email = $row['email'];
	$firstandlastnamekek = $row['first_last_name'];
	$bio = $row['bio'];
	$cover_pic = $row['cover_pic'];
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

$result = mysqli_query($con, "SELECT * FROM `faq`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
    $first = $row['first'];
    $second = $row['second'];
    $third = $row['third'];
    $fourth = $row['fourth'];
}
?>


<?php include("noob/header.php"); ?>

 <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title text-primary">WEBSITE TERMS</h4>
                  <p class="card-description">
                    <?php echo $first ?>
                  </p>
                </div>
                <div class="card-body">
                  <h4 class="card-title text-danger">SITE ACCOUNT</h4>
                  <p class="card-description">
                   <?php echo $second ?>
                  </p>
                </div>
                <div class="card-body">
                  <h4 class="card-title text-warning">REFUNDS POLICY</h4>
                  <p class="card-description">
                 <?php echo $third ?>
                  </p>
                </div>
                <div class="card-body">
                  <h4 class="card-title text-warning">GENERATOR</h4>
                  <p class="card-description">
                 <?php echo $fourth ?>
                  </p>
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