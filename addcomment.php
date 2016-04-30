<?php
session_start();
include("connection.php"); //Establishing connection with our database

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

    if (!($data = $db->prepare("SELECT userID FROM users WHERE username=?;"))) {
        echo "fail";
    }

    if (!$data->bind_param('s', $name1)) {
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
    {
        /* Bind the result to variables */
        // $data->bind_result($id);

        //$row=$data->fetch();
        //echo $name." ".$email." ".$password;
        // $id = $row['userID'];


        $query = $db->prepare("INSERT INTO comments (description, userID,photoID) VALUES (?,?,?)") or die(mysqli_error($db));
        if ($data->num_rows < "1") { //Uses the stored result and counts the rows.

            $msg = "Sorry...This email already exists...";
        } else {
            //echo $name." ".$email." ".$password;
            $query = $db->prepare("INSERT INTO comments (description,photoID) VALUES (?,?)") or die(mysqli_error($db));
            $query->bind_param("ss", $desc, $photoID);
            $query->execute();
            if ($query) {
                $msg = "Thank You! you have submitted your comment succesfully";
            }

        }
    }
}
    ?>