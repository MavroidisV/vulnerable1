<?php
$msg = "";
if(isset($_POST["submit"]))
{
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // To protect from MySQL injection
    $name = stripslashes($name);
    $password = stripslashes($password);
    $email = stripslashes($email);
    $name = mysqli_real_escape_string($db, $name);
    $password = mysqli_real_escape_string($db, $password);
    $email = mysqli_real_escape_string($db, $email);
    $name=htmlspecialchars ($name);
    $password=htmlspecialchars($password);
    $email=htmlspecialchars($email);

    $password = md5($password);
    
    $sql="SELECT email FROM users WHERE email='$email'";
    $result=mysqli_query($db,$sql);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(mysqli_num_rows($result) == 1)
    {
        $msg = "Sorry...This email already exists...";
    }
    else
    {
        //echo $name." ".$email." ".$password;
        $query = mysqli_query($db, "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$password')")or die(mysqli_error($db));
        if($query)
        {
            $msg = "Thank You! you are now registered. click <a href='index.php'>here</a> to login";
        }

    }
}
?>