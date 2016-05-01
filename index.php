<?php
	include('login.php'); // Include Login Script

	if ((isset($_SESSION['username']) != '')) 
	{
		header('Location: photos.php');
	}	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PHP Login Form with Session</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<div class="main">
<h1 style="font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; font-size:32px;">Welcome to Photo Commenter</h1>
    <div class="formbox">
        <h3>Login Form</h3>
        <br><br>
        <form method="post" action="">
            <label>Username:</label><br>
            <input type="text" name="username" placeholder="username" /><br><br>
            <label>Password:</label><br>
            <input type="password" name="password" placeholder="password" />  <br><br><br>
            <label>Captcha:</label><br>
            <p><img src="/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
            <p></p><input type="text" size="4" maxlength="5" name="captcha" placeholder="copy the digits from the image here" value=""></p>
            <input type="submit" name="submit" value="Login" />
        </form>
        <div class="error"><?php echo $error;?></div>
        <div class="register">You can register <a href="register.php"> here </a> </div>
    </div>

</div>
</body>
</html>