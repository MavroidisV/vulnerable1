<?php
session_start();
include("connection.php"); //Establishing connection with our database


if(isset($_GET['id']))
{
    $photoID = $_GET['id'];

echo $photoID;

    //Check username from db
    if (!($data=$db->prepare("DELETE FROM photos WHERE photoID=?;")))
    {echo "fail";}

    if(!$data->bind_param('s',$photoID)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }

    if (!$data -> execute()){
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }
    
   
    
    if ($data) {
        header("Location: photos.php");
    }
    else {
        echo "Sorry, there was an error deleting the file.";
    }
    //echo $name." ".$email." ".$password

}

?>