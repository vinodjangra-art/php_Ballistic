<?php 
session_start();
session_destroy();
echo "redirected to login page";
header("Location: Login.php");

$message = "Your session is about to expire!";
echo "<script type='text/javascript'>alert('$message');</script>";

?>