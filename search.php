<?php
$resultText = "";
if(isset($_POST["submit"]))
{
    $name = $_POST["username"];


    //Check username and password from database
    if (!($data=$db->prepare("SELECT userID FROM users WHERE username=?;")))
    {echo "fail";}

    if(!$data->bind_param('s',$name)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }


    if (!$data -> execute()){
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    $data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it
   // $row=$data->fetch();
    echo $row;
    



    
    if ($data->num_rows >= "1")
   {
       $data->bind_result($id);
        //$searchID = $row['userID'];
       $row=$data->fetch();

        
        $searchSql="SELECT title, photoID FROM photos WHERE userID='$id'";
        $searchresult=mysqli_query($db,$searchSql);

        if(mysqli_num_rows($searchresult)>0){
            while($searchRow = mysqli_fetch_assoc($searchresult)){
                $line = "<p><a href='photo.php?id=".$searchRow['photoID']."'>".$searchRow['title']."</a></p>";
                $resultText = $resultText.$line;
            }
        }
        else{
            $resultText = "no photos by user";
        }
    }
    else
    {
        $resultText = "no user with that username";

    }
}
?>