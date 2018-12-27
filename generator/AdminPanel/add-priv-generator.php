<?php

include "inc/header.php";

if ($_SESSION['rank'] < "5") {
	header('Location: ../haha.php');
	exit();
}


if (isset($_POST['addgenerator'])){
	$name = mysqli_real_escape_string($con, $_POST['addgenerator']);
	$max = mysqli_real_escape_string($con, $_POST['max']);
	$link = mysqli_real_escape_string($con, $_POST['link']);
	$about = mysqli_real_escape_string($con, $_POST['about']);
	$stock = mysqli_real_escape_string($con, $_POST['stock']);
	$stockcolor = mysqli_real_escape_string($con, $_POST['stockcolor']);
	mysqli_query($con, "INSERT INTO `privgenerators` (`name`, `max`, `link` , `about` , `stock` , `stockcolor`) VALUES ('$name', '$max' , '$link' , '$about' , '$stock' , '$stockcolor')") or die(mysqli_error($con));
	
	$result = mysqli_query($con, "SELECT * FROM `privgenerators` WHERE `name` = '$name'") or die(mysqli_error($con));
	while($row = mysqli_fetch_assoc($result)) {
		$accountid = $row['id'];
	}
	
	mysqli_query($con, "CREATE TABLE `privgenerator$accountid` (id INT NOT NULL AUTO_INCREMENT,alt VARCHAR(1000),status INT(1) DEFAULT '1',uses INT(11) DEFAULT '0',primary key (id))") or die(mysqli_error($con));
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

if (isset($_POST['editgenerator']) & isset($_POST['generatorid'])){
	$id = mysqli_real_escape_string($con, $_POST['generatorid']);
	$name = mysqli_real_escape_string($con, $_POST['editgenerator']);
	$max = mysqli_real_escape_string($con, $_POST['editmax']);
	$link = mysqli_real_escape_string($con, $_POST['editlink']);
	$about = mysqli_real_escape_string($con, $_POST['editabout']);
	$stock = mysqli_real_escape_string($con, $_POST['editstock']);
	$stockcolor = mysqli_real_escape_string($con, $_POST['editstockcolor']);
	mysqli_query($con, "UPDATE `privgenerators` SET `name` = '$name' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `privgenerators` SET `max` = '$max' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `privgenerators` SET `link` = '$link' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `privgenerators` SET `about` = '$about' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `privgenerators` SET `stock` = '$stock' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `privgenerators` SET `stockcolor` = '$stockcolor' WHERE `id` = '$id'") or die(mysqli_error($con));
}

if (isset($_POST['alts']) & isset($_POST['generator'])){
    $id = mysqli_real_escape_string($con, $_POST['generator']);
    mysqli_query($con,"DELETE FROM `privgenerator$id`") or die(mysqli_error($con));
    $values = htmlspecialchars($_POST['alts']);
    $array = explode("\n", $values);
    foreach($array as $line){
        $line = mysqli_real_escape_string($con, $line);
        if (!empty($line)) {
            mysqli_query($con, "INSERT INTO `privgenerator$id` (`alt`) VALUES ('$line')") or die(mysqli_error($con));
        }
    }
}


if ($_GET['action'] == "resetall"){
	mysqli_query($con, "TRUNCATE TABLE `privstatistics`") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "add-priv-generator.php");
		</script>
	';
}

if (isset($_GET['reset'])){
	$id = mysqli_real_escape_string($con, $_GET['reset']);
	
	$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `id` = '$id'") or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		$user = $row['username'];
	}
	echo $user;
	mysqli_query($con, "DELETE FROM `privstatistics` WHERE `username` = '$user'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "add-priv-generator.php");
		</script>
	';
}

$privgeneratedtoday = 0;

$result = mysqli_query($con, "SELECT * FROM `privstatistics` WHERE `date` = '$date'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
	$privgeneratedtoday = $privgeneratedtoday + $row['generated'];
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
                  <center><h4 class="card-title">Add Private Generators</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
							    <div id="collapse">
								<button class="btn btn-primary btn-block" data-toggle="collapse" data-target=".addgenerator" data-parent="#collapse"><i class="icon-plus"></i> Add Generator</button></br>
								<form action="add-priv-generator.php" method="POST">
									<div class="addgenerator sublinks collapse">
										<legend></legend>

                                 <div class="form-group has-success">
                                 <label>Name:</label></br>
										<input name="addgenerator" type="text" class="form-control" placeholder="Ex. Netflix" required ></br>
										<label>Max Alts:</label></br>
										<input name="max" type="text" class="form-control" placeholder="Ex. 3" required ></br>
										<label>Link To Site:</label></br>
										<input name="link" type="text" class="form-control" placeholder="Link to external site Ex. https://netflix.com" required ></br>
										<label>Accounts In Stock ? (color)</label></br>
										       	<select name="stockcolor" class="form-control">
											<option value="success" selected>Yes (Green)</option>
											<option value="danger">No (Red)</option>
										</select>
										<p></p>
										<label>Accounts In Stock: (Name)</label></br>
											       	<select name="stock" class="form-control">
											<option value="In Stock" selected>In Stock (Select this when accounts are in this generator)</option>
											<option value="Out Of Stock">Out Of Stock (Select this when there are no accounts in the generator)</option>
										</select>
										<p></p>
										<label>Description:</label></br>
										<textarea name="about" type="text" class="form-control"   placeholder="This is required, for this just type the name of the generator in google and copy and paste the description(This is for the account list page) " required></textarea></br>
										<button type="submit" class="btn btn-primary btn-block"><i class="icon-plus"></i> Add Generator</button></br>
									</div>
								</form>
							  </div>
							  </div>
							  <legend></legend>
							  <div class="panel-group" id="accordion">
								<?php
								$accountsquery = mysqli_query($con, "SELECT * FROM `privgenerators`") or die(mysqli_error($con));
								while($row = mysqli_fetch_assoc($accountsquery)){
									$generatorid = $row[id];
									$getgeneratorsquery = mysqli_query($con, "SELECT * FROM `privgenerator$generatorid`") or die(mysqli_error($con));
									$generatoramount = mysqli_num_rows($getgeneratorsquery);
									echo '
									   <div class="panel panel-info">
										  <div class="panel-heading">
											  <h4 class="panel-title">
												  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row[id].'" aria-expanded="false">'.$row[name].'&nbsp <span class="badge bg-success">'.$generatoramount.'</span></a>
												  <a href="add-priv-generator.php?deletegenerator='.$row[id].'" class="btn btn-xs btn-danger pull-right"><i class="fa fa-trash"></i></a>
												  <a class="btn btn-primary btn-xs pull-right" data-toggle="modal" href="#editgenerator" data-generator="'.$row['name'].'" data-max="'.$row['max'].'" data-link="'.$row['link'].'" data-about="'.$row['about'].'" data-stock="'.$row['stock'].'" data-stockcolor="'.$row['stockcolor'].'" data-generatorid="'.$row['id'].'"><i class="mdi mdi-settings"></i></a>
											  </h4>
										  </div>
										  <div id="collapse'.$row[id].'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
											  <div class="panel-body" style="background:#F1F2F7;">
												  <form action="add-priv-generator.php" method="POST">
													<input type="hidden" name="generator" value="'.$row[id].'">
													<textarea name="alts" rows="5" class="form-control" placeholder="username:password username:password">';
                                                    while($row = mysqli_fetch_assoc($getgeneratorsquery))
                                                    {
                                                        echo $row['alt']."\n";
                                                    }
                                                    echo '</textarea>
													<br>
													<button type="submit" class="btn btn-info btn-large btn-block">Update Alts</button>
												  </form>
											  </div>
										  </div>
									  </div></br>
									  <legend></legend>
									';
								}
								?>
							  </div>
						  </div>
					  </section>
				  </div>
              </div></div>
    

	        <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <center><h4 class="card-title">Upload image for the generator</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
			    
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
	</div>
                        </div><!-- container -->

                            <!-- Modal -->
<div id="editgenerator" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
            <h4 class="modal-title">Edit Generator</h4>

      </div>
      <div class="modal-body">
        <p>
            
            
             <form action="add-priv-generator.php" method="POST">
					    <input type="hidden" name="generatorid">
						<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group has-success">
                                 <label>Name:</label></br>
                                 <input type="text" class="form-control" name="editgenerator">
                                            </div>
                                        </div>
                          
                            <div class="col-md-6">
                            <div class="form-group has-success">
                                 <label>Edit Mx Alts:</label></br>
                                <input type="text" class="form-control" name="editmax">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                            <div class="form-group has-success">
                                 <label>Edit Link:</label></br>
                                <input type="text" class="form-control" name="editlink">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group has-success">
                                 <label>Edit Accounts In Stock ? (color)</label></br>
                                   	<select name="editstockcolor" class="form-control">
											<option value="success" selected>Yes (Green)</option>
											<option value="danger">No (Red)</option>
										</select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group has-success">
                                 <label>Edit Accounts In Stock ? (Name)</label></br>
                                <select name="editstock" class="form-control">
											<option value="In Stock" selected>In Stock (Select this when accounts are in this generator)</option>
											<option value="Out Of Stock">Out Of Stock (Select this when there are no accounts in the generator)</option>
										</select>
                                            </div>
                                        </div>
                        
                                        	<div class="col-sm-12">
								    <div class="form-group has-success">
                                <label>Description</label></br>
								<textarea name="editabout" class="form-control" ></textarea></br>
							 </div>
                                        </div>
                    </div>
					   </form>
            	  <div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
						<button class="btn btn-primary" type="submit"> Update</button>
                      </div>
            
            </p>
      </div>

    </div>

  </div>
</div>
                

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

<?php include("noob/footer.php"); ?>
	<script>
		$('#editgenerator').on('show.bs.modal', function(e) {
			var generator = $(e.relatedTarget).data('generator');
			var max = $(e.relatedTarget).data('max');
			var link = $(e.relatedTarget).data('link');
			var about = $(e.relatedTarget).data('about');
			var stock = $(e.relatedTarget).data('stock');
			var stockcolor = $(e.relatedTarget).data('stockcolor');
			var generatorid = $(e.relatedTarget).data('generatorid');
			$(e.currentTarget).find('input[name="editgenerator"]').val(generator);
			$(e.currentTarget).find('input[name="editmax"]').val(max);
			$(e.currentTarget).find('input[name="editlink"]').val(link);
			$(e.currentTarget).find('textarea[name="editabout"]').val(about);
			$(e.currentTarget).find('select[name="editstock"]').val(stock);
			$(e.currentTarget).find('select[name="editstockcolor"]').val(stockcolor);
			$(e.currentTarget).find('input[name="generatorid"]').val(generatorid);
		});
		
		$('#editpackage').on('show.bs.modal', function(e) {
			var package = $(e.relatedTarget).data('package');
			var packageid = $(e.relatedTarget).data('packageid');
			var price = $(e.relatedTarget).data('price');
			var length = $(e.relatedTarget).data('length');
			var accounts = $(e.relatedTarget).data('accounts');
			var generator = $(e.relatedTarget).data('generator');
			$(e.currentTarget).find('input[name="editpackage"]').val(package);
			$(e.currentTarget).find('input[name="packageid"]').val(packageid);
			$(e.currentTarget).find('input[name="editprice"]').val(price);
			$(e.currentTarget).find('input[name="editmax"]').val(accounts);
		});
	</script>
    </body>

</html>