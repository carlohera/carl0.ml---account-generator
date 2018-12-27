<?php

include 'inc/header.php';

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
if (mysqli_num_rows($result) < 1 && $_SESSION['rank'] != "5") {
	$subscription = "0";
}else{
	$subscription = "1";
}

if(isset($_POST['purchase'])){
	$id = sec_tag($con, $_POST['purchase']);
	$result = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$id'") or die(mysqli_error($con));

	while ($row = mysqli_fetch_array($result)) {
		$packageprice = $row['price'];
		$packagename = $website." - ".$row['name'];
		$custom = $row['id']."|".$username;
	}
	

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="sidebar.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo $favicon;?>">

    <!-- Page title -->
    <title>Redeem Page</title>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>

    <!-- App styles -->
    <link rel="stylesheet" href="styles/pe-icons/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="styles/pe-icons/helper.css"/>
    <link rel="stylesheet" href="styles/stroke-icons/style.css"/>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="blank">

<!-- Wrapper-->
<div class="wrapper">


    <!-- Main content-->
    <section class="content">


        <div class="container-center animated slideInDown">


            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Redeem Upgrade Code</h3>
                    <small>
                        Please enter the upgrade code give after you purchase
                    </small>
                </div>
            </div>
<div class="panel panel-filled">
                <div class="panel-body">
                     <form method="POST">
                        <div class="form-group">
                            <label class="control-label" for="email">Your Code:</label>
                            <form method="post" action="forgotpassword.php" style="margin-left: 500px; margin-right: 500px;">
                             <input type="text" name="fcode" placeholder="First Code" class="form-control no-border">
                             <p></p>
                             <input type="text" name="scode" placeholder="Second Code" class="form-control no-border">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary brn-block" name="doActivate">Submit</button>
                            <a class="btn btn-default pull-right" href="purchase.php">Go Back</a>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->
    
   


</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="vendor/pacejs/pace.min.js"></script>
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- App scripts -->
<script src="scripts/luna.js"></script>

</body>

</html>