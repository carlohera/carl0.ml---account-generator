<?php

include 'inc/header.php';

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
if (mysqli_num_rows($result) < 1 && $_SESSION['rank'] != "5") {
	$subscription = "0";
}else{
	$subscription = "1";
}
  if(isset($_GET['ref'])){
        $_SESSION['ref'] = $_GET['ref'];
    }

if(isset($_POST['purchase'])){
	$id = mysqli_real_escape_string($con, $_POST['purchase']);
	$result = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$id'") or die(mysqli_error($con));

	while ($row = mysqli_fetch_array($result)) {
		$packageprice = $row['price'];
		$packagename = $website." - ".$row['name'];
		$custom = $row['id']."|".$username;
	}
	
	$paypalurl = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&amount=".urlencode($packageprice)."&business=".urlencode($paypal)."&page_style=primary&item_name=".urlencode($packagename)."&return=http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI'])."/purchase.php?action=buy-success&rm=2&notify_url=http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI'])."/lib/ipn.php"."&cancel_return=http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI'])."/purchase.php?action=buy-error&custom=".urlencode($custom)."&mc_currency=USD";
	header('Location: '.$paypalurl);
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
                  <center><h4 class="card-title"><?php echo $website; ?> Choose A Package</h4></center>
                  
                  
                    
		<?php
		  if($_GET['action'] == "buy-success"){
			  $result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
			  if (mysqli_num_rows($result) < 1) {
				  echo '
				  <div class="alert bg-primary" role="alert">
	Waiting for purchase to complete, If it does not complete please message support with your paypal email and the package bought, or message <a href="steamcommunity.com/id/carlohera" target="_blank">Owen </a> Or <a href="https://www.facebook.com/carlohera" target="_blank">Carlo</a>
				</div>
									<script type="text/javascript">
										window.setTimeout(function(){window.location.href="purchase.php?action=buy-success"},10000);
									</script>
				  ';
			  }else{
				echo '
					  <div class="alert bg-success" role="alert">
					Thanks for your purchase! You have succesfully received your subscription package.
					Visit the <a href="generator.php">Generator Page</a> to start generating.
					</div>
				';
			  }
		  }
		  ?>
       
								<div class="table-sorter-wrapper col-lg-12 ">
                      <table id="sortable-table-2" class="table table-striped"> 
                              <tbody>
              
                    <tr>
                        <th>
                            <div class="th-inner ">Name</div>
                            <div class="fht-cell"></div>
                        </th>
                        <th>
                            <div class="th-inner ">Price</div>
                            <div class="fht-cell"></div>
                        </th>
                        <th>
                            <div class="th-inner ">Generator(s)</div>
                            <div class="fht-cell"></div>
                        </th>
						<th>
                            <div class="th-inner ">Length</div>
                            <div class="fht-cell"></div>
                        </th>
						<th>
                            <div class="th-inner ">Accounts</div>
                            <div class="fht-cell"></div>
                        </th>
                        	<th>
                            <div class="th-inner ">Generator History</div>
                            <div class="fht-cell"></div>
                        </th>
						<th>
                            <div class="th-inner ">Purchase</div>
                            <div class="fht-cell"></div>
                        </th>

                    </tr>
                                            </tbody>
                <tbody>
                        <?php
					$result = mysqli_query($con, "SELECT * FROM `packages` ORDER BY CAST(price AS DECIMAL(10,2))");
					while ($row = mysqli_fetch_assoc($result)) {
						if($row['generator'] == ""){
							$generatorname = "All";
						}else{
							$generatorquery = mysqli_query($con, "SELECT * FROM `generators` WHERE `id` = '$row[generator]'") or die(mysqli_error($con));
							while($row1 = mysqli_fetch_array($generatorquery)){
								$generatorname = $row1['name'];
							}
						}
						if($row['accounts'] == "0" || $row['accounts'] == ""){
							$accounts = "Unlimited";
						}else{
							$accounts = $row['accounts']."/day";
						}
						$name = $row['name'];
						$price = $row['price'];
						$length = $row[length];
						$gen_history = $row[gen_history];
						echo "
						<tr>
						<td>$name</td>
						<td>$price<span style='color: #009900;'>$</span></td>
						<td>$generatorname</td>
						<td>$length</td>
						<td>$accounts</td>
						<td>$gen_history</td>
						<td>
						".'<form method="POST" action="purchase.php">
										<input type="hidden" name="purchase" value="'.$row[id].'"/>
										<button type="submit" class="btn btn-primary"
						';
						if ($subscription != "0" || $_SESSION['rank'] == "5"){
							echo "enabled";
						}
						echo '
										>Buy Now</button>
									  </form>'."
						</td>

						</td>
						</tr>
						";
					}
					?>
                                            </tbody></table>
        </div> </div>
    </div> </div>
</div> </div>
 <?php include("noob/footer.php"); ?>
    
    <?php
    if($_GET['action'] == "buy-success"){
        echo "<script type='text/javascript'>
                $(document).ready(function(){
                $('#buy-success').modal('show');
                });
              </script>"
        ;
    }
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });

                $(".knob").knob();

            });
        </script>



<!--End of Tawk.to Script-->
    </body>

</html>