<?php 
include("includes/connection.php");
session_start();
$logged_user=$_SESSION['user_email'];
$select_user="select * from users where user_email='$logged_user'";
$run_user=mysqli_query($con,$select_user);
$row_user =mysqli_fetch_array($run_user);

$logged_user_id=$row_user['user_id'];
?>