<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<?php

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
}</style>

<div class="card">
                <div class="card-body">
                  <h4 class="card-title">News</h4>
                 
                  <div class="mt-5">
                    <div class="vertical-timeline">
                      <div class="timeline-wrapper timeline-wrapper-warning">
                        <div class="timeline-badge"></div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h6 class="timeline-title"><?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 1");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['title'].'</b></td>';
								}
								?>
                            	
                            </h6>
                          </div>
                          <div class="timeline-body">
                           <?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 1");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['message'].'</b></td>';
								}
								?>
                          </div>
                          <div class="timeline-footer d-flex align-items-center">
                              </br>
                              <span>by 
                              	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 1");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['writer'].'</b></td>';
								}
								?>
                              </span>
                              <span class="ml-auto font-weight-bold"><?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 1");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['date'].'</b></td>';
								}
								?>

                              </span>
                          </div>
                        </div>
                      </div>
                      <div class="timeline-wrapper timeline-inverted timeline-wrapper-danger">
                        <div class="timeline-badge"></div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h6 class="timeline-title">
                            	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 2");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['title'].'</b></td>';
								}
								?>
                            </h6>
                          </div>
                          <div class="timeline-body">
                            
                            	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 2");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['message'].'</b></td>';
								}
								?>
                            
                          </div>
                          <div class="timeline-footer d-flex align-items-center">
                              
                              <span>by 
                              	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 2");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['writer'].'</b></td>';
								}
								?>
                              </span>
                              <span class="ml-auto font-weight-bold">
                              	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 2");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['date'].'</b></td>';
								}
								?>
                              </span>
                          </div>
                        </div>
                      </div>
                      <div class="timeline-wrapper timeline-wrapper-success">
                        <div class="timeline-badge"></div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h6 class="timeline-title">
                            	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 3");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['title'].'</b></td>';
								}
								?>
                            </h6>
                          </div>
                          <div class="timeline-body">
                            
                            	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 3");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['message'].'</b></td>';
								}
								?>
                            
                          </div>
                          <div class="timeline-footer d-flex align-items-center">
                              
                              <span>by 
                              	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 3");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['writer'].'</b></td>';
								}
								?>
                              </span>
                              <span class="ml-auto font-weight-bold">
                              	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 3");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['date'].'</b></td>';
								}
								?>
                              </span>
                          </div>
                        </div>
                      </div>
                      <div class="timeline-wrapper timeline-inverted timeline-wrapper-info">
                        <div class="timeline-badge"></div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h6 class="timeline-title">
                            	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 4");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['title'].'</b></td>';
								}
								?>
                            </h6>
                          </div>
                          <div class="timeline-body">
                            
                            	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 4");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['message'].'</b></td>';
								}
								?>
                            
                          </div>
                          <div class="timeline-footer d-flex align-items-center">
                             
                              <span>by 
                              	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 4");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['writer'].'</b></td>';
								}
								?>
                              </span>
                              <span class="ml-auto font-weight-bold">
                              	<?php
									$result = mysqli_query($con, "SELECT * FROM `news` WHERE `id` = 4");
									while ($row = mysqli_fetch_assoc($result)) {
									echo '<td><b>'.$row['date'].'</b></td>';
								}
								?>
                              </span>
                          </div>

                          </div>
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