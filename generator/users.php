<?php

include "inc/header.php";

$id = $_GET['id'];
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
                  <center><h4 class="card-title">Active Users</h4></center>
                  
                  
                    <div class="table-sorter-wrapper col-lg-12 table-responsive">
                      <table id="sortable-table-2" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Rank</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                                               <?php 
                                            $result = mysqli_query($con, "SELECT * FROM `users` WHERE `active` = 1 ORDER BY `id` DESC");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        
                                    echo '
                                        <tr>
                                            <th scope="row"><img src="'.$row['profile_img'].'" width="25" height="25"></th>
                                            <td>'.$row['username'].'</td>
                                            <td>'.$row['first_last_name'].'</td>';
                                                    if($row['rank'] == "1"){echo '<td>Member</td>';}elseif($row['rank'] == "5"){echo '<td>Admin</td>';}elseif($row['rank'] == "4"){echo '<td>Cracker</td>';}else{echo '<td></td>';}
                                            echo '
                                        </tr>
                                         ';
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
</div></div>
                            </div>
<div class="col-md-6 h-100">
                      <div class="bg-light p-4">
                        <h6 class="card-title">Staff</h6>
                        <div id="profile-list-right" class="py-2">
                          <div class="card rounded mb-2">
                            <div class="card-body p-3">
                              <div class="media">
                                <img src="https://i.imgur.com/wOVxdJP.png" alt="image" class="img-sm mr-3 rounded-circle">
                                <div class="media-body">
                                  <h6 class="mb-1"><a href="https://steamcommunity.com/id/carlohera">Carlo H </a></h6>
                                  <p class="mb-0 text-muted">
                                    Developer
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>

                   
                <!-- end col -->
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