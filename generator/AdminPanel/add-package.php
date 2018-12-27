<?php
	require_once('pieces/header.php');
	require_once('pieces/inc.php');
include "inc/header.php";

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


if (isset($_POST['addpackage']) & isset($_POST['price']) & isset($_POST['generator']) & isset($_POST['length'])){
	$name = mysqli_real_escape_string($con, $_POST['addpackage']);
	$price = mysqli_real_escape_string($con, $_POST['price']);
	$generator = mysqli_real_escape_string($con, $_POST['generator']);
	$max = mysqli_real_escape_string($con, $_POST['max']);
	$length = mysqli_real_escape_string($con, $_POST['length']);
	$gen_history = mysqli_real_escape_string($con, $_POST['gen_history']);
	$priv_generator = mysqli_real_escape_string($con, $_POST['priv_generator']);
	mysqli_query($con, "INSERT INTO `packages` (`name`, `price`, `length`, `generator`, `gen_history`, `priv_generator`, `accounts`) VALUES ('$name', '$price', '$length', '$generator', '$gen_history', '$priv_generator', '$max')") or die(mysqli_error($con));
}

if (isset($_GET['deletepackage'])){
	$id = mysqli_real_escape_string($con, $_GET['deletepackage']);
	mysqli_query($con, "DELETE FROM `packages` WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "add-package.php");
		</script>
	';
}

if (isset($_POST['editpackage']) & isset($_POST['packageid']) & isset($_POST['editprice']) & isset($_POST['editgenerator']) & isset($_POST['editlength'])){
	$id = mysqli_real_escape_string($con, $_POST['packageid']);
	$name = mysqli_real_escape_string($con, $_POST['editpackage']);
	$price = mysqli_real_escape_string($con, $_POST['editprice']);
	$generator = mysqli_real_escape_string($con, $_POST['editgenerator']);
	$length = mysqli_real_escape_string($con, $_POST['editlength']);
	$gen_history = mysqli_real_escape_string($con, $_POST['editgen_history']);
	$priv_generator = mysqli_real_escape_string($con, $_POST['editpriv_generator']);
	$max = mysqli_real_escape_string($con, $_POST['editmax']);
	mysqli_query($con, "UPDATE `packages` SET `name` = '$name' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `packages` SET `price` = '$price' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `packages` SET `generator` = '$generator' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `packages` SET `length` = '$length' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `packages` SET `gen_history` = '$gen_history' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `packages` SET `priv_generator` = '$priv_generator' WHERE `id` = '$id'") or die(mysqli_error($con));
	mysqli_query($con, "UPDATE `packages` SET `accounts` = '$max' WHERE `id` = '$id'") or die(mysqli_error($con));
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
                  <center><h4 class="card-title">News & Updates</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
			    	<div id="collapse">
								<button class="btn btn-primary btn-block" data-toggle="collapse" data-target=".addpackage" data-parent="#collapse"><i class="icon-plus"></i> Add Package</button></br>
								<form action="add-package.php" method="POST">
									<div class="addpackage sublinks collapse">
								        <lable>Name</lable>
										<input name="addpackage" type="text" class="form-control" placeholder="Name (Ex. Gold Package)"></br>
										<label>Price</label>
										<input name="price" type="text" class="form-control" placeholder="Price (Ex. 0.01)"></br>
										<label>Generators</label>
										<select name="generator" class="form-control">
											<option value="" selected>All Generators</option>
											<?php
												$accountsquery = mysqli_query($con, "SELECT * FROM `generators`") or die(mysqli_error($con));
												while($row = mysqli_fetch_assoc($accountsquery)){
													echo '<option value="'.$row[id].'">'.$row[name].'</option>';
												}
											?>
										</select></br>
										<label>Time</label>
										<select name="length" class="form-control">
											<option value="Lifetime" selected>Lifetime</option>
											<option value="1 Day">1 Day</option>
											<option value="3 Days">3 Days</option>
											<option value="1 Week">1 Week</option>
											<option value="1 Month">1 Month</option>
											<option value="2 Months">2 Months</option>
											<option value="3 Months">3 Months</option>
											<option value="4 Months">4 Months</option>
											<option value="5 Months">5 Months</option>
											<option value="6 Months">6 Months</option>
											<option value="7 Months">7 Months</option>
											<option value="8 Months">8 Months</option>
											<option value="9 Months">9 Months</option>
											<option value="10 Months">10 Months</option>
											<option value="11 Months">11 Months</option>
											<option value="12 Months">12 Months</option>
										</select></br>
										<label>Gen History</label>
										<select name="gen_history" class="form-control">
											<option value="Yes" selected>Yes</option>
											<option value="No">No</option>
										</select></br>
										<label>Private Generator</label>
										<select name="priv_generator" class="form-control">
											<option value="Yes" selected>Yes</option>
											<option value="No">No</option>
										</select></br>
										<label>Alts Per Day</label>
										<input type="number" name="max" class="form-control" placeholder="Max accounts/day (Leave empty for unlimited)"></br>
										<button type="submit" class="btn btn-primary btn-block"><i class="icon-plus"></i> Add Package</button></br>
									</div>
								</form>
							  </div>
						
							  <div class="panel-group" id="accordion">
								<?php
								$packagesquery = mysqli_query($con, "SELECT * FROM `packages`") or die(mysqli_error($con));
								while($row = mysqli_fetch_assoc($packagesquery)){
									echo '
									  <div class="panel panel-info">
										  <div class="panel-heading">
											  <h4 class="panel-title">
												  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#2collapse'.$row[id].'" aria-expanded="false">'.$row[name].'&nbsp <span class="badge bg-success">$'.$row[price].'</span></a>
												  <a href="add-package.php?deletepackage='.$row[id].'" class="btn btn-xs btn-danger pull-right"><i class="fas fa-times-circle"></i></a>
												  <a class="btn btn-primary btn-xs pull-right" data-toggle="modal" href="#editpackage" data-package="'.$row['name'].'" data-packageid="'.$row['id'].'" data-price="'.$row['price'].'" data-length="'.$row['length'].'" data-accounts="'.$row['accounts'].'" data-generator="'.$row['generator'].'" data-gen_history="'.$row['gen_history'].'" data-priv_generator="'.$row['priv_generator'].'"><i class="fas fa-cog"></i></a>
											  </h4>
										  </div>
										  <div id="2collapse'.$row[id].'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
											  <div class="panel-body" style="background:#00000;">
												  <form action="add-package.php" method="POST">
													<input type="hidden" name="package" value="'.$row[id].'">
													<br>
													<button type="submit" class="btn btn-primary btn-large btn-block"><i class="fas fa-cog"></i> Edit Package</button>
												  </form>
											  </div>
										  </div>
									  </div></br>
									 
									';
								}
								?>
					</div>
					</form>
  
			</div>
		</div>
	</div>
                   
                   
                   
                   
                   
                   		  
		  <!-- Modal -->
		  <div class="modal fade" id="editpackage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
				  <div class="modal-content">
					  <div class="modal-header">
						  <h4 class="modal-title">Edit Package</h4>
					  </div>
					  <div class="modal-body">
					   <form action="add-package.php" method="POST">
					    <input type="hidden" name="packageid">
						<div class="form-group">
						  <label>Name</label>
						  <input type="text" class="form-control" name="editpackage">
						</div>
						<div class="form-group">
						  <label>Price</label>
						  <input type="text" class="form-control" name="editprice">
						</div>
						<div class="form-group">
							<label>Generator(s)</label>
							<select name="editgenerator" class="form-control">
								<option value="">All Generators</option>
								<?php
									$accountsquery = mysqli_query($con, "SELECT * FROM `generators`") or die(mysqli_error($con));
									while($row = mysqli_fetch_assoc($accountsquery)){
										echo '<option value="'.$row[id].'">'.$row[name].'</option>';
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Length</label>
							<select name="editlength" class="form-control">
								<option value="Lifetime">Lifetime</option>
								<option value="1 Day">1 Day</option>
								<option value="3 Days">3 Days</option>
								<option value="1 Week">1 Week</option>
								<option value="1 Month">1 Month</option>
								<option value="2 Months">2 Months</option>
								<option value="3 Months">3 Months</option>
								<option value="4 Months">4 Months</option>
								<option value="5 Months">5 Months</option>
								<option value="6 Months">6 Months</option>
								<option value="7 Months">7 Months</option>
								<option value="8 Months">8 Months</option>
								<option value="9 Months">9 Months</option>
								<option value="10 Months">10 Months</option>
								<option value="11 Months">11 Months</option>
								<option value="12 Months">12 Months</option>
							</select>
						</div>
						<div class="form-group">
							<label>Gen History</label>
							<select name="editgen_history" class="form-control">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
						<div class="form-group">
							<label>Private Generator</label>
							<select name="editpriv_generator" class="form-control">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
						<div class="form-group">
							<label>Max accounts/day</label>
							<input type="number" name="editmax" class="form-control" placeholder="(Leave empty for unlimited)">
						</div>
					  </div>
					  <div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
						<button class="btn btn-primary" type="submit"> Update</button>
                      </div>
					   </form>
				  </div>
			  </div>

                        </div><!-- container -->
 </div>
            <!-- End Right content here -->

        </div>

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

           
        <!-- END wrapper -->

<?php include("noob/footer.php"); ?>
	<script>
		$('#editgenerator').on('show.bs.modal', function(e) {
			var generator = $(e.relatedTarget).data('generator');
			var generatorid = $(e.relatedTarget).data('generatorid');
			$(e.currentTarget).find('input[name="editgenerator"]').val(generator);
			$(e.currentTarget).find('input[name="generatorid"]').val(generatorid);
		});
		
		$('#editpackage').on('show.bs.modal', function(e) {
			var package = $(e.relatedTarget).data('package');
			var packageid = $(e.relatedTarget).data('packageid');
			var price = $(e.relatedTarget).data('price');
			var length = $(e.relatedTarget).data('length');
			var accounts = $(e.relatedTarget).data('accounts');
			var generator = $(e.relatedTarget).data('generator');
			var gen_histroy = $(e.relatedTarget).data('gen_histroy');
			var priv_generator = $(e.relatedTarget).data('priv_generator');
			$(e.currentTarget).find('input[name="editpackage"]').val(package);
			$(e.currentTarget).find('input[name="packageid"]').val(packageid);
			$(e.currentTarget).find('input[name="editprice"]').val(price);
			$(e.currentTarget).find('input[name="editmax"]').val(accounts);
			$(e.currentTarget).find('select[name="editgen_histroy"]').val(gen_histroy);
			$(e.currentTarget).find('select[name="editpriv_generator"]').val(priv_generator);
		});
	</script>
    </body>

</html>