<?php
$resultText = "";
if(isset($_SESSION['username']))
{
    $name = $_SESSION["username"];

    

    //Check userid from db
    if (!($data=$db->prepare("SELECT userID FROM users WHERE username=?;")))
    {echo "fail";}

    if(!$data->bind_param('s',$name)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }


    if (!$data -> execute()){
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    $data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it



    if ($data->num_rows == "1")
        
   
    {

        /* Bind the result to variables */
        $data->bind_result($searchID);

        $row=$data->fetch();


        $searchSql="SELECT title, photoID,url FROM photos WHERE userID='$searchID'";
        $searchresult=mysqli_query($db,$searchSql);

        if(mysqli_num_rows($searchresult)>0)
   {
            while($searchRow = mysqli_fetch_assoc($searchresult)){
                $line = "<p><a href='photo.php?id=".$searchRow['photoID']."'>".$searchRow['title']."</a><br><img src='".$searchRow['url']."' style='width:100px;height:100px;'><p></p>";
                $resultText = $resultText.$line;
            }
        }
        else{
            $resultText = "no photos by you!";
        }
    }
    else
    {
        $resultText = "no user with that username";

    }
}
?>