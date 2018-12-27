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
// Create a new CSRF token.
if (! isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}
// Check a POST is valid.
if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    // POST data is valid.
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
  <?php
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo '';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo '
        
        <div class="alert alert-success"> <i class="ti-bell"></i>  The file '. basename( $_FILES["fileToUpload"]["name"]). ' has been uploaded.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        </div>

        ';
    } else {
        echo '';
    }
}
   



?>
  
                    
                    <?php
function testInput($data){
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

 
                    $username = $_SESSION['username'];
$message = testInput($_POST['message']);
if (!preg_match("/^[a-zA-Z ]*$/",$message)) {
$message = mysqli_real_escape_string($con, $message);
die("In message field Only letters allowed"); 
}
$contains = "script";
if(isset($_POST['username']) && preg_match("/\b($contains)\b/", $username && $email))
{
die("We Dont Accept XSS Around Here");
}

if (isset($_POST['message']) & isset($_POST['to']) & isset($_SESSION['username'])) {
	$to = mysqli_real_escape_string($con, $_POST['to']);
	$message = mysqli_real_escape_string($con, $_POST['message']);
	$pic = mysqli_real_escape_string($con, $_POST['pic']);
	$date = date("Y-m-d");
	mysqli_query($con, "INSERT INTO `messageuser` (`from`, `to`, `message`, `pic`, `status`, `date`) VALUES ('$username', '$to', '$message', '/$target_file', '0', DATE('$date'))") or die(mysqli_error($con));
	echo '

                    
           <div class="alert alert-success"> <i class="ti-bell"></i>   Message Successfully Sent 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        </div>


	
	
	
		';
						
}
                    
                    ?>
                    
                    
                    <?php
                    
                    if (isset($_GET['read'])){
	$id = mysqli_real_escape_string($con, $_GET['read']);
	mysqli_query($con, "UPDATE `messageuser` SET `status` = '1' WHERE `id` = '$id'") or die(mysqli_error($con));
	echo '
		<script>
			window.history.replaceState("object or string", "Title", "messageuser.php");
		</script>
		
		<div class="alert alert-success"> <i class="ti-bell"></i>   Set Read Successful
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        </div>
	';
}
                    
                    ?>
                    

            <div class="col-lg-4 grid-margin stretch-card">
              <!--x-editable starts-->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Send Messages</h4>
                  <p class="card-description">No Spam You Will Be Banned</p>
                  <div class="template-demo">
                            <form action="messageuser.php" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                                
                                               <select class="select2 form-control" id="select2" name="to" style="width: 100%;" data-placeholder="Choose one..">
                                                   <?php
												$accountsquery = mysqli_query($con, "SELECT * FROM `users`") or die(mysqli_error($con));
												while($row = mysqli_fetch_assoc($accountsquery)){
													echo '
                                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                    <option value="'.$row['username'].'">'.$row['username'].'</option>
                                                    ';
												}
											?>
                                                </select>                                   
                                         
                                                </div>
                                          </div>
                                        </div>
                                        </div>
                                                 <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <textarea name="message" class="form-control" rows="4" placeholder="Type your message here..." required ></textarea></br>
                                              <button name="sent" class=" btn btn-warning btn-large btn-block" >Send Message</button>
                                            </div>
                                          </div>
                                          
                                        </div>
                                        
                                        </form>
                              
                                    </p>
                                   

                                </ul>
                        </div>
                    </div>
                    </div>
                    
                    
                              <div class="col-lg-8 grid-margin stretch-card">
              <!--x-editable starts-->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Sent Messages</h4>
                  <p class="card-description">All Sent Messages</p>
                  <div class="template-demo">
                              <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>From</th>
                              <th>Message</th>
                              <th>Date</th>
                              
                              
                            </tr>
                          </thead>
                              <tbody>
                   
                  <?php
									$result = mysqli_query($con, "SELECT * FROM `messageuser` ORDER BY `id` DESC " );
									while ($row = mysqli_fetch_assoc($result)) {
									echo '
									<td><b>'.$row['from'].'</b></td>
											<td><b>'.$row['message'].'</b></td>
											<td><b> '.$row['date'].'</b></td>
											
											
										</tr>
									';
									}
								?>
                              </tbody>
                          </table>
                              </div>
                        </div></div></div>
                   </div><hr><div class="row">
                   <div class="col-lg-12 grid-margin stretch-card">
              <!--x-editable starts-->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Messages</h4>
                  
                  <div class="template-demo">
                              <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>To</th>
                                  <th>From</th>
                              <th>Message</th>
                              <th>Date</th>
                              
                            </tr>
                          </thead>
                              <tbody>
                                 <?php
									$result = mysqli_query($con, "SELECT * FROM `messageuser` WHERE `from` = '$username' ORDER BY `id` DESC" );
									while ($row = mysqli_fetch_assoc($result)) {
									echo '
									
											<td><b>'.$row['to'].'</b></td>
											<td><b> '.$row['from'].'</b></td>
											<td><b>'.$row['message'].'</b></td>
											<td><b>Date: '.$row['date'].' </b></td>
										</tr>
									';
									}
								?>
                              </tbody>
                          </table>
                              
                              
                                    </p>
                                   

                                </ul>
                        </div>
                    </div>
                    </div>
           </div></div>
   <?php include("noob/footer.php"); ?>