<?php

//display error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	session_start();
	include("connection.php"); //Establishing connection with our database
	
	$error = ""; //Variable for storing our errors.
	if(isset($_POST["submit"]))
	{
		if(empty($_POST["username"]) || empty($_POST["password"]))
		{
			$error = "Both fields are required.";
		}else
		{
			// Define $username and $password
			$username=$_POST['username'];
			$password=$_POST['password'];



			//Check username and password from database
			if (!($data=$db->prepare("SELECT userID FROM users WHERE username=(:username) and password=(:password);")))
			{echo "fail";}
	
			$data->bind_param(1,$username );
			$data->bind_param(2,$password );

			
			
			
			
			
			//Check username and password from database
			//$data=$db->prepare=('SELECT userID FROM users WHERE username=? and password=?;');
			
			//$data->bind_param('ss',$username,$password );
			$data -> execute();
			//$row=$data->fetch();
			$result=mysqli_query($db,$data);
			$row=mysqli_fetch_array($result,MYSQLI_ASSOC) ;
			
			//If username and password exist in our database then create a session.
			//Otherwise echo error.
			
			if(mysqli_num_rows($result) == 1)
			{
				$_SESSION['username'] = $username; // Initializing Session
				header("location: photos.php"); // Redirecting To Other Page
			}else
			{
				$error = "Incorrect username or password.";
			}

		}
	}

?>