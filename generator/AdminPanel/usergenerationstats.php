<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}

if (isset($_GET['deletegenerator'])){
	$id = mysqli_real_escape_string($con, $_GET['deletegenerator']);
	mysqli_query($con, "DROP TABLE `privgenerator$id`") or die(mysqli_error($con));
	mysqli_query($con, "DELETE FROM `privgenerators` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "add-priv-generator.php");
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
                  <center><h4 class="card-title">User Generations</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 ">
                      <table id="sortable-table-2" class="table table-striped">
                                       	  <thead>
									  <tr>
										  <th><i class="fa fa-user-circle"></i> Username</th>
										  <th><i class="fa fa-refresh"></i> Generator</th>
										  <th><i class="fa fa-repeat"></i> Account</th>
										  <th><i class="fa fa-calendar"></i> Time</th>

									  </tr>
									  </thead>
									  <tbody class="searchable">
									  <?php
                  $result = mysqli_query($con, "SELECT * FROM `statistics_det` ");
                  while ($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>
										    <td>'.$row['username'].'</td>
									    <td>'.$row['gen'].'</td>
									    <td>'.$row['account'].'</td>
									    <td>'.$row['time'].'</td>
											</tr>';
										}
										?>
									  </tbody>
                                    </table>
			</div>
		</div>
	</div>
                   	
                   
                        </div><!-- container -->


                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->
                
                
                
                
                
    
                

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


    <?php include("noob/footer.php"); ?>
    </body>

</html>