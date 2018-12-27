<?php
	require_once('pieces/header.php');
	require_once('pieces/inc.php');
	require_once('inc/header.php');

	
	if(isset($_POST['generate'])) {
		$selector = sec_tag($con, $_POST['selector']);
		
		$serv = mysqli_query($sql, 'SELECT * FROM dumps WHERE DumpCategory = "'.$selector.'" ORDER BY RAND() LIMIT 1');
		$acc = mysqli_fetch_array($serv);
		
		$alt = $acc['DumpAlt'];
	}
	
	$serv = mysqli_query($sql, 'SELECT * FROM dumps ORDER BY DumpID');
?>
 
 <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Description" content="Royalty Generator, We have two types of generators, Free & Paid this gives you a chance to get some free accounts before moving to our paid generator " >
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo $favicon;?>">
<script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Page title -->
    <title>Windowed Chat</title>

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

         <div class="content-page">
                <!-- Start content -->
                <div class="content">
       <div class="panel panel-primary">
                            <div class="panel-heading">
                                ChatBox
                            </div>
                       

                            <div class="panel-body">
                                <div id="retshouts"></div>

                                <div class="input-group">
                                    <input class="form-control" placeholder="Enter your message..." maxlength="150" id="shout" required>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary" onclick="shout()">Send</button>
                                        

</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="vendor/pacejs/pace.min.js"></script>
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- App scripts -->
<script src="scripts/luna.js"></script>
	<script>
        
        function shout() {
            $.post("php/ajax/sb.php?action=shout", {
                message: $("#shout").val()
            }, function(data) {
                switch (data) {
                    case "done":
                        $("#shout").val("");
                        break;
                    case "banned":
                        toastr.error("You have been banned from the shoutbox.");
                        break;
                    case "spam":
                        toastr.error("Please wait. There is a 3 seconds wait limit between messages.");
                        break;
                }
            })
        }

        function getShouts() {
            $.post("php/ajax/sb.php?action=get", function(data) {
                $("#retshouts").html(data);

            }).complete(function() {
                setTimeout(function() {
                    getShouts();
                }, 1000);
            });
        }

        $(document).keypress(function(e) {
            if (e.which == 13) {
                shout();
            }
        });
        getShouts();
    </script>

</body>

</html>