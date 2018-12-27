<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}


if (isset($_POST['addgenerator'])){
	$name = mysqli_real_escape_string($con, $_POST['addgenerator']);
	mysqli_query($con, "INSERT INTO `freegenerators` (`name`) VALUES ('$name')") or die(mysqli_error($con));
	
	$result = mysqli_query($con, "SELECT * FROM `freegenerators` WHERE `name` = '$name'") or die(mysqli_error($con));
	while($row = mysqli_fetch_assoc($result)) {
		$accountid = $row['id'];
	}
	
	mysqli_query($con, "CREATE TABLE `freegenerator$accountid` (id INT NOT NULL AUTO_INCREMENT,alt VARCHAR(1000),status INT(1) DEFAULT '1',uses INT(11) DEFAULT '0',primary key (id))") or die(mysqli_error($con));
}

if (isset($_GET['deletegenerator'])){
	$id = mysqli_real_escape_string($con, $_GET['deletegenerator']);
	mysqli_query($con, "DROP TABLE `freegenerator$id`") or die(mysqli_error($con));
	mysqli_query($con, "DELETE FROM `freegenerators` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-freegen.php");
		</script>
	';
}

if (isset($_POST['editgenerator']) & isset($_POST['generatorid'])){
	$id = mysqli_real_escape_string($con, $_POST['generatorid']);
	$name = mysqli_real_escape_string($con, $_POST['editgenerator']);
	$max = mysqli_real_escape_string($con, $_POST['editmax']);
	$link = mysqli_real_escape_string($con, $_POST['editlink']);
	$about = mysqli_real_escape_string($con, $_POST['editabout']);
	$stock = mysqli_real_escape_string($con, $_POST['editstock']);
	$stockcolor = mysqli_real_escape_string($con, $_POST['editstockcolor']);
	mysqli_query($con, "UPDATE `freegenerators` SET `name` = '$name' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `freegenerators` SET `max` = '$max' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `freegenerators` SET `link` = '$link' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `freegenerators` SET `about` = '$about' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `freegenerators` SET `stock` = '$stock' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `freegenerators` SET `stockcolor` = '$stockcolor' WHERE `id` = '$id'") or die(mysqli_error($con));
}

if (isset($_POST['alts']) & isset($_POST['generator'])){
	$id = mysqli_real_escape_string($con, $_POST['generator']);
	mysqli_query($con,"DELETE FROM `freegenerator$id`") or die(mysqli_error($con));
	$values = htmlspecialchars($_POST['alts']);
	$array = explode("\n", $values);
	foreach($array as $line){
		$line = mysqli_real_escape_string($con, $line);
		if (!empty($line)) {
			mysqli_query($con, "INSERT INTO `freegenerator$id` (`alt`) VALUES ('$line')") or die(mysqli_error($con));
		}
	}
}


if ($_GET['action'] == "resetall"){
	mysqli_query($con, "TRUNCATE TABLE `freestatistics`") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-freegen.php");
		</script>
	';
}

if (isset($_GET['reset'])){
	$id = mysqli_real_escape_string($con, $_GET['reset']);
	
	$result = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `id` = '$id'") or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		$user = $row['username'];
	}
	echo $user;
	mysqli_query($con, "DELETE FROM `freestatistics` WHERE `username` = '$user'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-freegen.php");
		</script>
	';
}

$freegeneratedtoday = 0;

$result = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `date` = '$date'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$freegeneratedtoday = $freegeneratedtoday + $row['generated'];
}


if ($_GET['action'] == "resetall"){
	mysqli_query($con, "TRUNCATE TABLE `freestatistics`") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-freegen.php");
		</script>
	';
}

if (isset($_GET['reset'])){
	$id = mysqli_real_escape_string($con, $_GET['reset']);
	
	$result = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `id` = '$id'") or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		$user = $row['username'];
	}
	echo $user;
	mysqli_query($con, "DELETE FROM `freestatistics` WHERE `username` = '$user'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-freegen.php");
		</script>
	';
}

$freegeneratedtoday = 0;

$result = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `date` = '$date'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$freegeneratedtoday = $freegeneratedtoday + $row['generated'];
}

if (isset($_GET['deleteacc'])){
	$id = mysqli_real_escape_string($con, $_GET['deleteacc']);
	mysqli_query($con, "DELETE FROM `freegen_history` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "manage-freegen.php");
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
                  <center><h4 class="card-title">Add Free Generators</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                    <div id="collapse">
								<button class="btn btn-primary btn-block" data-toggle="collapse" data-target=".addgenerator" data-parent="#collapse"><i class="icon-plus"></i> Add Generator</button></br>
								<form action="manage-freegen.php" method="POST">
									<div class="addgenerator sublinks collapse">
										<legend></legend>

                                 <div class="form-group has-success">
                                 <label>Name:</label></br>
										<input name="addgenerator" type="text" class="form-control" placeholder="Ex. Netflix" required ></br>
										<button type="submit" class="btn btn-primary btn-block"><i class="icon-plus"></i> Add Generator</button></br>
									</div>
								</form>
							  </div>
							  </div>
						
							  <div class="panel-group" id="accordion">
						
							<?php
								$accountsquery = mysqli_query($con, "SELECT * FROM `freegenerators`") or die(mysqli_error($con));
								while($row = mysqli_fetch_assoc($accountsquery)){
									$generatorid = $row[id];
									$getgeneratorsquery = mysqli_query($con, "SELECT * FROM `freegenerator$generatorid`") or die(mysqli_error($con));
									$generatoramount = mysqli_num_rows($getgeneratorsquery);
									echo '
									  <div class="panel panel-info">
										  <div class="panel-heading">
											  <h4 class="panel-title">
												  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row[id].'" aria-expanded="false">'.$row[name].'&nbsp <span class="badge bg-success">'.$generatoramount.'</span></a>
												  <a href="manage-freegen.php?deletegenerator='.$row[id].'" class="btn btn-primary btn-danger pull-right"><i class="fa fa-trash"></i></a>
												  <a class="btn btn-primary btn-xs pull-right" data-toggle="modal" href="#editgenerator" data-generator="'.$row['name'].'" data-link="'.$row['link'].'" data-about="'.$row['about'].'" data-stock="'.$row['stock'].'" data-stockcolor="'.$row['stockcolor'].'" data-generatorid="'.$row['id'].'"><i class="fas fa-cogs"></i></a>
											  </h4>
										  </div>
										  <div id="collapse'.$row[id].'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
											  <div class="panel-body" style="background:#00000;">
												  <form action="manage-freegen.php" method="POST">
													<input type="hidden" name="generator" value="'.$row[id].'">
													<textarea name="alts" rows="5" class="form-control" placeholder="username:password username:password">';
													while($row = mysqli_fetch_assoc($getgeneratorsquery))
													{
														echo $row['alt']."\n";
													}
													echo '</textarea>
													<br>
													<button type="submit" class="btn btn-primary btn-large btn-block">Update Alts</button>
												  </form>
											  </div>
										  </div>
									  </div></br>
								
									';
								}
								?>
						
					</div>
					</form>



                                        </div>      </div>
                                    </div>
                                </div>
               
                                

	        <div class="col-6">
                                    <div class="card m-b-20">
                                        <div class="card-block">
                                            <h4 class="mt-0 m-b-15 header-title">Upload image for the generator</h4>
			    
			    Before you upload the image make sure it is named exactly the same as the generator you are uploading the image for example: Netflix.png   (NOTE: all images MUST be .png)
			    <p></p>
			     <form action="../upload.php" method="post" enctype="multipart/form-data">
     Select image to upload:

<input class="btn btn-primary" type="file" name="fileToUpload" id="fileToUpload">
<legend></legend>
<input class="btn btn-primary btn-block" type="submit" value="Upload Image" name="submit">

</form>
  
			</div>
		</div>
	</div>		</div>
		</div>
                   
             <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Generator Stats</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                    <table id="datatable" class="table table-striped table-bordered">
                                       
                                       	  <thead>
									  <tr>
										   <th><i class="fa fa-user-circle"></i> Username</th>
										  <th><i class="fa fa-refresh"></i> Generator</th>
										  <th><i class="fa fa-repeat"></i> Account</th>
										  <th><i class="fa fa-calendar"></i> Time</th>
										  <th></th>

									  </tr>
									  </thead>
									  <tbody class="searchable">
										  <?php
                  $result = mysqli_query($con, "SELECT * FROM `freegen_history` ");
                  while ($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>
										    <td>'.$row['username'].'</td>
									    <td>'.$row['gen'].'</td>
									    <td>'.$row['account'].'</td>
									    <td>'.$row['time'].'</td>
									    <td><a href="manage-freegen.php?deleteacc='.$row[id].'" class="btn btn-xs btn-danger pull-right"><i class="fa fa-remove"></i>Remove Account</a></td>
											</tr>';
										}
										?>
									  </tbody>
                                    </table>
			</div>
		</div>
	</div>		</div>
	
	
	
         <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Free Generator Stats</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                    <table id="datatable" class="table table-striped table-bordered">
                                       
                                       	  <thead>
									  <tr>
										  <th><i class="fa fa-user-circle"></i> Username</th>
										  <th><i class="fa fa-refresh"></i> Total Generated</th>
										  <th><i class="fa fa-calendar"></i> Generated Today</th>
										  <th></th>

									  </tr>
									  </thead>
									  <tbody class="searchable">
										<?php
										$result = mysqli_query($con, "SELECT * FROM `freestatistics` GROUP BY `username`") or die(mysqli_error($con));
										while ($row = mysqli_fetch_array($result)) {
											$freeusertotalgenerated = 0;
											$result2 = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `username` = '$row[username]'") or die(mysqli_error($con));
											while ($row2 = mysqli_fetch_array($result2)) {
												$freeusertotalgenerated = $freeusertotalgenerated + $row2['generated'];
											}
											$result3 = mysqli_query($con, "SELECT * FROM `freestatistics` WHERE `username` = '$row[username]' AND `date` = '$date'") or die(mysqli_error($con));
											if(mysqli_num_rows($result3) < 1){
												$freeusergeneratedtoday = "0";
											}else{
												while ($row3 = mysqli_fetch_array($result3)) {
													$freeusergeneratedtoday = $row3['generated'];
												}
											}
											echo '<tr>
											  <td><a href="#">' . $row['username'] . '</a></td>
											  <td>'.$freeusertotalgenerated.'</td>
											  <td>'.$freeusergeneratedtoday.'</td>
											  <td><a class="btn btn-primary btn-xs" href="manage-freegen.php?reset='.$row['id'].'"><i class="fa fa-remove-circle "> Reset</i></a></td>
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



         <?php include("noob/footer.php"); ?>
    </body>

</html>