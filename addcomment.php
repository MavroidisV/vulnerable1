<?php
session_start();
include("connection.php"); //Establishing connection with our database
//set time zone and date variable
date_default_timezone_set('UTC');
$date = date('Y-m-d');

$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"])) {

    $desc = $_POST["desc"];
    $photoID = $_POST["photoID"];
    $name1 = $_SESSION["username"];

    // To protect from MySQL injection and XSS
    $desc = stripslashes($desc);
    $photoID = stripslashes($photoID);

    $desc = mysqli_real_escape_string($db, $desc);
    $photoID = mysqli_real_escape_string($db, $photoID);
    $desc = htmlspecialchars($desc);
    $photoID = htmlspecialchars($photoID);
    //prepared statement
    if (!($data = $db->prepare("SELECT userID FROM users WHERE username=?;"))) {
        echo "fail";
    }
    //bind the parameters
    if (!$data->bind_param('s', $name1)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }

    //execute the statement
    if (!$data->execute()) {
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    $data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it

    
    $data->bind_result($id);
    $row = $data->fetch();
  
//Check username from db
if (!($data=$db->prepare("INSERT INTO comments (description, postDate,photoID,userID) VALUES (?,?,?,?)")))
{echo "fail";}

if(!$data->bind_param('ssss',$desc,$date,$photoID,$id)) {
    echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
}

if (!$data -> execute()){
    echo "Execute failed: (" . $data->errno . ") " . $data->error;
}




    if ($data) {
        $msg = "Thank You! comment added. click <a href='photo.php?id=" . $photoID . "'>here</a> to go back";

    } else {
        $msg = "You need to login first";
    }
}

?>  