<?php

//display error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("connection.php"); //Establishing connection with our database

$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"])) {

    $desc = $_POST["desc"];
    $photoID = $_POST["photoID"];
    $name = $_SESSION["username"];

    // To protect from MySQL injection and XSS
    $desc = stripslashes($desc);
    $photoID = stripslashes($photoID);

    $desc = mysqli_real_escape_string($db, $desc);
    $photoID = mysqli_real_escape_string($db, $photoID);
    $desc = htmlspecialchars($desc);
    $photoID = htmlspecialchars($photoID);

    if (!($data = $db->prepare("SELECT userID FROM users WHERE username=?;"))) {
        echo "fail";
    }

    if (!$data->bind_param('s', $name)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }


    if (!$data->execute()) {
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    $data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it

    //$sql="SELECT userID FROM users WHERE username='$name'";
    // $result=mysqli_query($db,$sql);
    // $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    //  if(mysqli_num_rows($result) == 1) {
    $row = $data->fetch();
    //if ($data->num_rows == "1")

    /* Bind the result to variables */
    // $data->bind_result($id);

    //$row=$data->fetch();
    //echo $name." ".$email." ".$password;
    // $id = $row['userID'];
echo "ok upto now";

    $data = $db->prepare("INSERT INTO comments (description,photoID) VALUES (?,?)") or die(mysqli_error($db));
    $data->bind_param("ss", $desc, $photoID);
    $data->execute();
    // $query = mysqli_query($db, $addsql) or die(mysqli_error($db));
    if ($data) {
        $msg = "Thank You! comment added. click <a href='photo.php?id=" . $photoID . "'>here</a> to go back";
    } else {
        $msg = "You need to login first";
    }

}
?>