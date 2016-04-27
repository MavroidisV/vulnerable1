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
			$username1=$_POST['username'];
			$password=$_POST['password'];



			//Check username and password from database
			if (!($data=$db->prepare("SELECT userID FROM users WHERE username=? and password=?;")))
			{echo "fail";}
	
			if(!$data->bind_param('ss',$username1,$password )) {
				echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
			}
			

			
			
			
			
			
			//Check username and password from database
			//$data=$db->prepare=('SELECT userID FROM users WHERE username=? and password=?;');
			
			//$data->bind_param('ss',$username,$password );
			if (!$data -> execute()){
				echo "Execute failed: (" . $data->errrno . ") " . $data->error;
			}
			//$data->bind_result($userID);

			//$result=mysqli_query($db,$data);
			$row=$data->fetch();
			//$result=mysqli_query($db,$data);
			//$row=mysqli_fetch_array($result,MYSQLI_ASSOC) ;
			
			//If username and password exist in our database then create a session.
			//Otherwise echo error.
			if ( $data->rowCount()== 1 )
			//if(mysqli_num_rows($row) == 1)
			{
				$_SESSION['username'] = $username1; // Initializing Session
				header("location: photos.php"); // Redirecting To Other Page
			}else
			{
				$error = "Incorrect username or password.";
			}

		}
	}

?>