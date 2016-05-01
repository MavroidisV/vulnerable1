<?php
session_start();
include("connection.php"); //Establishing connection with our database


if(isset($_GET['id']))
{
    $photoID = $_GET['id'];



    //Check username from db
    if (!($data=$db->prepare("DELETE FROM photos FROM photos WHERE photoID=?;")))
    {echo "fail";}

    if(!$data->bind_param('s',$photoID)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }

    if (!$data -> execute()){
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    //$data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it

    /* Bind results to variables */
    $data->bind_result($commentID, $description, $postDate, $userID, $photoID);
    
    if ($data) {
        header("Location: photos.php");
    }
    else {
        echo "Sorry, there was an error deleting the file.";
    }
    //echo $name." ".$email." ".$password

}

?>