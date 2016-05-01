<?php
session_start();
include("connection.php"); //Establishing connection with our database

$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $url = "test";
    $name = $_SESSION["username"];

    // To protect from MySQL injection and XSS
    $title = stripslashes($title);
    $desc = stripslashes($desc);

    $desc = mysqli_real_escape_string($db, $desc);
    $title = mysqli_real_escape_string($db, $title);
    $desc = htmlspecialchars($desc);
    $title = htmlspecialchars($title);

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $uploadOk = 1;

    if (!($data = $db->prepare("SELECT userID FROM users WHERE username=?;"))) {
        echo "fail";
    }

    if (!$data->bind_param('s', $name)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }


    if (!$data->execute()) {
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    $data->store_result();

   // $sql="SELECT userID FROM users WHERE username='$name'";
   // $result=mysqli_query($db,$sql);
   // $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $data->bind_result($id);
    $row = $data->fetch();

    if ($data->num_rows == "1") {
        //$timestamp = time();
        //$target_file = $target_file.$timestamp;
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //$id = $row['userID'];
            $addsql = "INSERT INTO photos (title, description, postDate, url, userID) VALUES ('$title','$desc',now(),'$target_file','$id')";
            $query = mysqli_query($db, $addsql) or die(mysqli_error($db));
            if ($query) {
                $msg = "Thank You! The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. click <a href='photos.php'>here</a> to go back";
            }

        } else {
            $msg = "Sorry, there was an error uploading your file.";
        }
        //echo $name." ".$email." ".$password;


    }
    else{
        $msg = "You need to login first";
    }
}

?>