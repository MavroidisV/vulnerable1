<?php
	include("check.php");
	include("userphotos.php");


$ip = getenv('REMOTE_ADDR');
echo $ip;

if ($ip == $_SESSION['ip']){
	header("location: photos.php");
}
//echo "you are eligible user";}
else {header("location: photos.php");}
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
</div>
<a href='addphotoform.php'> Add New Photo </a>;

</body>
</html>