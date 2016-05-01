<?php
session_start();
include("connection.php"); //Establishing connection with our database

//set default time zone
date_default_timezone_set('UTC');
$date = date('Y-m-d');

$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"])) {
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
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $uploadOk = 1;
    //prepared statement
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
        // if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //$id = $row['userID'];
        // this code actually checks the mime type of the file being uploaded
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileContents = file_get_contents($FILES['some_name']['tmp_name']);
        $mimeType = $finfo->buffer($fileContents);
    }

        
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" & $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG,PNG and GIF  files are allowed.";
        $uploadOk = 0;
    }

        //check if file exists
        // if (file_exists($target_file)){echo "sorry file already exists";
        //$uploadOk=0;}

        //check file size
            //if ($_FILES["fileToUpload"]["size"]>500000){echo "sorry your file is too large";
                 //$uploadOk=0;}
    //check if image file is actual image or fake
    $check=getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check!==false){echo "file is an image-" .$check["mime"].".";
    $uploadOk=1;}
    else {echo "file isnt an image.";
    $uploadOk=0;}

        if ($uploadOk == 1) {
            if (!($data = $db->prepare("INSERT INTO photos (title,description, postDate,url,userID) VALUES (?,?,?,?,?)"))) {
                echo "fail";
            }

            if (!$data->bind_param('sssss', $title, $desc, $date, $target_file, $id)) {
                echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
            }

            if (!$data->execute()) {
                echo "Execute failed: (" . $data->errno . ") " . $data->error;
            }


            //$addsql = "INSERT INTO photos (title, description, postDate, url, userID) VALUES ('$title','$desc',now(),'$target_file','$id')";
            // $query = mysqli_query($db, $addsql) or die(mysqli_error($db));
            if ($data) {
                $msg = "Thank You! The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded. click <a href='photos.php'>here</a> to go back";
            }

        } else {
            $msg = "Sorry, there was an error uploading your file.";
        }
        //echo $name." ".$email." ".$password;

        // }
    

//}
}

?>