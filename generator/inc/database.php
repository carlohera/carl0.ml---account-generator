<?php
include "connection.php";
$myhost = "localhost";
$myuser = "generator";
$mypass = "password";
$mydb = "generator";


 $con = mysqli_connect($myhost, $myuser, $mypass, $mydb);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>