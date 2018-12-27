<?php

include "inc/header.php";

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
if (mysqli_num_rows($result) < 1 && $_SESSION['rank'] != "4" && $_SESSION['rank'] != "5") { 
	  header('Location: purchase.php');
 echo '<script>window.location = "'.trollface.'.php";</script>';
 }

 else{	
	while($row = mysqli_fetch_assoc($result)){
		$package = $row['package'];
		$checkpackage = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$package'") or die(mysqli_error($con));
		while($row1 = mysqli_fetch_assoc($checkpackage)){
			$generator = $row1['generator'];
		}
	}
}

if (isset($_POST['flagalt']) && isset($_POST['generator'])){
	$alt = sec_tag($con, $_POST['flagalt']);
	$generatorid = sec_tag($con, $_POST['generator']);
	mysqli_query($con, "UPDATE `generator$generatorid` SET `status` = '2' WHERE `alt` = '$alt'") or die(mysqli_error($con));
}

$totalalts = 0;

$result = mysqli_query($con, "SELECT * FROM `privgenerators`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$result2 = mysqli_query($con, "SELECT * FROM `privgenerator$row[id]` WHERE `status` != '0'") or die(mysqli_error($con));
	$totalalts = $totalalts + mysqli_num_rows($result2);
}

$generatestotal = 0;

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestotal = $generatestotal + $row['generated'];
}

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)) {
	$generatestoday = $row['generated'];
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
  			     <div class="col-md-12">
                      <div class="alert alert-info"><strong>Information!</strong> <strong>Please Do Not Change Any Account Information / Wait A Few Seconds After Pressing The Generate Button For The Account To Be Shown</strong></div></div>
       
                     
        

	     
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
						$generatorquery = "SELECT * FROM `privgenerators`";
					}else{
						$generatorquery = "SELECT * FROM `privgenerators` WHERE `id` = ".$generator;
					}
				
					$result = mysqli_query($con, $generatorquery) or die(mysqli_error($con));
					while ($row = mysqli_fetch_array($result)) {
						echo '
  <div class="col-md-3 grid-margin">
              <div class="card">
                <div class="card-body">'.$row['name'].'&nbsp;<a  href="'.$row['link'].'"  target="_blank"><i class="fa fa-external-link pull-right" aria-hidden="true"></i></a> </div>
								<div class="panel-body">
                                    <center><img class="faa-tada animated-hover" src="genimg/'.$row["name"].'.png" alt="'.$row["name"].'" width="150" height="150"></center></br>

                                    <center><p>Max '. $row['max'] .'/day</p></center>
									<input type="text" id="generator'.$row["id"].'" onclick="select_all(this)" class="text-center form-control" placeholder="username:password"></br>
								</div>

									<center><button id="generate'.$row["id"].'" style="padding: 5px; width: 95%;" class="btn btn-primary">Generate</button></center> 
								<p></p>
	
									<center><button id="copy'.$row["id"].'" data-clipboard-target="generator'.$row["id"].'" title="Copy" style="padding: 5px; width: 95%;" class="btn btn-success">Copy To Clipboard</button></center>

								</br>
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