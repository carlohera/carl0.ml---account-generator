<?php
include "inc/database.php";
include "inc/header.php";



if (isset($_POST['flagalt']) && isset($_POST['generator'])){
	$alt = sec_tag($con, $_POST['flagalt']);
	$generatorid = mysqli_real_escape_string($con, $_POST['generator']);
	mysqli_query($con, "UPDATE `freegenerator$generatorid` SET `status` = '2' WHERE `alt` = '$alt'") or die(mysqli_error($con));
}

$totalalts = 0;

$result = mysqli_query($con, "SELECT * FROM `freegenerators`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$result2 = mysqli_query($con, "SELECT * FROM `freegenerator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
	$totalalts = $totalalts + mysqli_num_rows($result2);
}

$generatestotal = 0;

$result = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestotal = $generatestotal + $row['generated'];
}

$result = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestoday = $row['generated'];
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
<center><div class="card-body">
                  <blockquote class="blockquote blockquote-primary">
                    <p><b><?php echo $website;?> - Free Genetrator </b></p><p>Accounts may not work as people will change them, we DO NOT add accounts all the time, we focus all our attention on the <a href="generator.php">Paid</a> & <a href="privategenerator.php">Private</a> generators.</b></p>
                    <footer class="blockquote-footer"><cite title="Source Title"><b>Want to see what account types we have on the "Paid" & "Private" Generator ?  <a href="accounts.php">See The Account List Page</a></b></cite></footer>
                  </blockquote></center>

                   <script type="text/javascript">
				function select_all(obj) {
					var text_val=eval(obj);
					text_val.focus();
					text_val.select();
					if (!document.all) return; // IE only
					r = text_val.createTextRange();
					r.execCommand('copy');
				}
			  </script>

    
	                  
							<?php
				
					if($generator == "" || $_SESSION['rank'] == 5){
						$generatorquery = "SELECT * FROM `freegenerators`";
					}else{
						$generatorquery = "SELECT * FROM `freegenerators` WHERE `id` = ".$generator;
					}
				
					$result = mysqli_query($con, $generatorquery) or die(mysqli_error($con));
					while ($row = mysqli_fetch_array($result)) {
						echo '
	 <div class="col-md-6 grid-margin">
              <div class="card">
                <div class="card-body">
            '.$row['name'].'  &nbsp;<a  href="'.$row['link'].'"  target="_blank"><i class="fas fa-arrow-alt-circle-right pull-right" aria-hidden="true"></i></a><center><img class="faa-tada animated-hover" src="genimg/'.$row["name"].'.png" alt="'.$row["name"].'" width="150" height="150"></center>   </div>
							<div class="card-body">
									<input name="alt" id="generator'.$row["id"].'" onclick="select_all(this)" style="text-align: center;" class="form-control" placeholder="username:password">
								</div>

								<center><button id="generate'.$row["id"].'" style="padding: 5px; width: 95%;" class="btn btn-primary">Generate</button></center> 
								<p></p>
	
								
							</div>
						</div>
						';
					}
		?>
              </div>

          </section>
      </section>
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
<script src="js/ZeroClipboard.js" ></script>

	<?php
	
	$result = mysqli_query($con, $generatorquery) or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		echo '
			<script>
			$(document).ready(function(){
				$("#generate'.$row["id"].'").click(function(){
				 $.get("lib/freegenerate.php?id='.$row["id"].'&name='.$row["name"].'&username='.$username.'", function(response){
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