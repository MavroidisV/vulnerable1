<?php
include('connection.php');
session_start();
$user_check=$_SESSION['username'];

//////
$_SESSION['logged_in'] = true; //set you've logged in
$_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
$_SESSION['expire_time'] = 1*60;


////



$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

$ses_sql = mysqli_query($db,"SELECT username, admin FROM users WHERE username='$user_check' ");

$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

$login_user=$row['username'];
if($row['admin']==1){
    $adminuser = true;
}

if(!isset($user_check))
{
header("Location: index.php");
}
?>