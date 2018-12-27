<?php
include '../inc/database.php';


			$amount = mysqli_real_escape_string($con, $_POST['mc_gross']);
			$currency = mysqli_real_escape_string($con, $_POST['mc_currency']);
			$paypal = mysqli_real_escape_string($con, $_POST['receiver_email']);
			$txnid = mysqli_real_escape_string($con, $_POST['txn_id']);
			$custom = explode("|",$_POST['custom']);
			$packageid = $custom[0];
			$username = $custom[1];
			$status = $_POST['payment_status'];

			if($status != "Completed")
			{
				exit();
			}

			$result = mysqli_query($con,"SELECT * FROM `settings`");
			while ($row = mysqli_fetch_array($result)) 
			{
				$realpaypal = $row['paypal'];
			}

			$result = mysqli_query($con,"SELECT * FROM `packages` WHERE `id` = '$packageid'");
			if(mysqli_num_rows($result) < "1")
			{
				exit();
			}
			while ($row = mysqli_fetch_array($result)) 
			{
				$realamount = $row['price'];
				$length = $row['length'];
			}
			
			if($realamount != $amount)
			{
				exit();
			}
			
			if($currency != "USD")
			{
				exit();
			}
			
			if($realpaypal != $paypal)
			{
				exit();
			}
			
			$today = time();

			if($length == "Lifetime"){
				$expiresdate = strtotime("100 years", $today);
			}elseif($length == "1 Day"){
				$expiresdate = strtotime("+1 day", $today);
			}elseif($length == "3 Days"){
				$expiresdate = strtotime("+3 days", $today);
			}elseif($length == "1 Week"){
				$expiresdate = strtotime("+1 week", $today);
			}elseif($length == "1 Month"){
				$expiresdate = strtotime("+1 month", $today);
			}elseif($length == "2 Months"){
				$expiresdate = strtotime("+2 months", $today);
			}elseif($length == "3 Months"){
				$expiresdate = strtotime("+3 months", $today);
			}elseif($length == "4 Months"){
				$expiresdate = strtotime("+4 months", $today);
			}elseif($length == "5 Months"){
				$expiresdate = strtotime("+5 months", $today);
			}elseif($length == "6 Months"){
				$expiresdate = strtotime("+6 months", $today);
			}elseif($length == "7 Months"){
				$expiresdate = strtotime("+7 months", $today);
			}elseif($length == "8 Months"){
				$expiresdate = strtotime("+8 months", $today);
			}elseif($length == "9 Months"){
				$expiresdate = strtotime("+9 months", $today);
			}elseif($length == "10 Months"){
				$expiresdate = strtotime("+10 months", $today);
			}elseif($length == "11 Months"){
				$expiresdate = strtotime("+11 months", $today);
			}elseif($length == "12 Months"){
				$expiresdate = strtotime("+12 months", $today);
			}else{
			exit();
			}

			$expires = date('Y-m-d', $expiresdate);
			$date = date("Y-m-d");
			mysqli_query($con, "INSERT INTO `subscriptions` (`username`, `date`, `price`, `payment`, `package`, `expires`, `txn_id`, `active`) VALUES ('$username', DATE('$date'), '$realamount', 'Paypal', '$packageid', DATE('$expires'), '$txnid', '1')") or die(mysqli_error($con));



$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) 
{
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
 

?>