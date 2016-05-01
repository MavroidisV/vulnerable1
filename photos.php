<?php
	include("check.php");
	include("userphotos.php");


$ip = getenv('REMOTE_ADDR');
//check ip
//echo $ip;

if ($ip == $_SESSION['ip']){ //echo "you are eligible user";
}
	else {header("location: index.php");}



$_SESSION['logged_in'] = true; //set you've logged in
$_SESSION['timeout'] = time(); //your last activity was now, having logged in.




?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>

<h4>Welcome <?php echo $login_user;?> <a href="photos.php" style="font-size:18px">Photos</a>||<a href="searchphotos.php" style="font-size:18px">Search</a>||<a href="logout.php" style="font-size:18px">Logout</a></h4>

<div id="photolist">
	<?php echo $resultText;?>
</div><br>
<a href='addphotoform.php'> Add New Photo </a>

</body>
</html>