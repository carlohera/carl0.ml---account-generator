<?php

include "inc/header.php";




date_default_timezone_set('UTC');

function humanTiming ($time)
{
	$time = strtotime("$time + 4 hours");

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}



if (isset($_POST['flagalt']) && isset($_POST['generator'])){
	$alt = mysqli_real_escape_string($con, $_POST['flagalt']);
	$generatorid = mysqli_real_escape_string($con, $_POST['generator']);
	mysqli_query($con, "UPDATE `generator$generatorid` SET `status` = '2' WHERE `alt` = '$alt'") or die(mysqli_error($con));
}

$totalalts = 0;

$result = mysqli_query($con, "SELECT * FROM `generators`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$result2 = mysqli_query($con, "SELECT * FROM `generator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
	$totalalts = $totalalts + mysqli_num_rows($result2);
}

$generatestotal = 0;

$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestotal = $generatestotal + $row['generated'];
}

$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestoday = $row['generated'];
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
         <div class="col-md-6 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Your Generation History</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                        <thead>
                                            <tr>
                               <th data-priority="1">Generator</th>
                               <th data-priority="2">Account Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                  $result = mysqli_query($con, "SELECT * FROM `statistics_det` WHERE `username` = '$username' ORDER BY `id` DESC ");
                  while ($row = mysqli_fetch_assoc($result)) {
                  echo '
                    <tr>
                      <td><span class="co-name">'.$row['gen'].'</span></td>
                      <td>'. $row['account'] .'</td>
                    </tr>
                  ';
                  }
                ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                   <div class="col-md-6 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Your Free Generation History</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                    <table id="tech-companies-1" class="table table-striped">
                                        <thead>
                                            <tr>
                               <th data-priority="1">Generator</th>
                               <th data-priority="2">Account Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                  $result = mysqli_query($con, "SELECT * FROM `freegen_history` WHERE `username` = '$username' ORDER BY `id` DESC ");
                  while ($row = mysqli_fetch_assoc($result)) {
                  echo '
                    <tr>
                      <td><span class="co-name">'.$row['gen'].'</span></td>
                      <td>'. $row['account'] .'</td>
                    </tr>
                  ';
                  }
                ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    
</div>
          </section>
      
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
      </section></div></div>
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
<script src="js/ZeroClipboard.js" ></script>

		<?php
	
	$result = mysqli_query($con, $generatorquery) or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		echo '
			<script>
			$(document).ready(function(){
				$("#generate'.$row["id"].'").click(function(){
				 $.get("lib/privgenerate.php?id='.$row["id"].'&name='.$row["name"].'&username='.$username.'", function(response){
					$("#generator'.$row["id"].'").val(response);
					$("#flag'.$row["id"].'").val(response);
				 });
				});
			});
			
			var client = new ZeroClipboard( document.getElementById("copy'.$row["id"].'") );

			client.on( "ready", function( readyEvent ) {

			  client.on( "aftercopy", function( event ) {
			  } );
			} );

			</script>
		';
	}
	
	?>



    </body>

</html>
