<?php
include("check.php");
include("addcomment.php");

$ip = getenv('REMOTE_ADDR');
//check ip
//echo $ip;


//ip binding= if its the same ok(session initiated ip vs right now! if its not redirect
if ($ip == $_SESSION['ip']){ //echo "you are eligible user";
}
else {header("location: index.php");}


if( $_SESSION['timeout'] +60 < time()){ session_destroy(); header("location: index.php");}

else {$_SESSION['timeout']=time();}



?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Comment</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<h4>Welcome <?php echo $login_user;?> <a href="photos.php" style="font-size:18px">Photos</a>||<a href="searchphotos.php" style="font-size:18px">Search</a>||<a href="logout.php" style="font-size:18px">Logout</a></h4>

<div class="main">

<div class="formbox">
    <form method="post" action="">
        <label>Comment:</label><br>
        <textarea name="desc" cols="40" rows="5"  ></textarea><br><br>
        <label>Photo:</label>
        <input type="text" name="photoID" value="<?php echo $_GET['id'] ?>" /><br><br>
        <input type="submit" name="submit" value="Submit Comment" />
    </form>
    <div class="msg"><?php echo $msg;?></div>
</div>
    </div>
</body>
</html>