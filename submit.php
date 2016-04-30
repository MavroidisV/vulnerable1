<?php
$msg = "";
if(isset($_POST["submit"]))
{
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // To protect from MySQL injection and XSS
    $name = stripslashes($name);
    $email = stripslashes($email);
    $password = stripslashes($password);

    $name = mysqli_real_escape_string($db, $name);
    $email = mysqli_real_escape_string($db, $email);
    $password = mysqli_real_escape_string($db, $password);


    $name = htmlspecialchars($name);
    $password = htmlspecialchars($password);
    $email = htmlspecialchars($email);


    $password = md5($password);


    if (!($data=$db->prepare("SELECT email FROM users WHERE email= ? ;")))
    {echo "fail";}

    if(!$data->bind_param('s',$email )) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }


    if (!$data -> execute()){
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    $data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it!

    $row=$data->fetch();
    

    if ($data->num_rows >= "1") { //Uses the stored result and counts the rows.
        
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