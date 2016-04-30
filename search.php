<?php
$resultText = "";
if(isset($_POST["submit"])) {
    $name = $_POST["username"];


    //Check username from db
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


    if ($data->num_rows >= "1") {
        /* Bind the result to variables */
        $data->bind_result($id);

        $row = $data->fetch();


///////

        if (!($data1 = $db->prepare("SELECT title, photoID FROM photos WHERE userID=?;"))) {
            echo "fail";
        }

        if (!$data1->bind_param('s', $id)) {
            echo "binding parameters failed: (" . $data1->errno . ")" . $data1->error;
        }


        if (!$data1->execute()) {
            echo "Execute failed: (" . $data1->errno . ") " . $data1->error;
        }

        $data1->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it


        if ($data1->num_rows > "0") {
            
            echo "alright up to here";

            $data1->bind_result($title, $photoID);

            $searchRow = $data1->fetch();
            
            echo $data1;


            //$searchSql="SELECT title, photoID FROM photos WHERE userID='$id'";
            // $searchresult=mysqli_query($db,$searchSql);

            //if(mysqli_num_rows($searchresult)>0){
            // while($searchRow = mysqli_fetch_assoc($searchresult)){
            $line = "<p><a href='photo.php?id=" . $searchRow['$photoi'] . "'>" . $searchRow['title'] . "</a></p>";
            $resultText = $resultText . $line;
        }

    }

    //else {
       // $resultText = "no photos by user";


     else

        $resultText = "no user with that username";

        // }

    //}
}
?>