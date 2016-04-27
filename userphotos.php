<?php
$resultText = "";
if(isset($_SESSION['username']))
{
    $name = $_SESSION["username"];

    $data=$db -> prepare('SELECT userID FROM users WHERE username= (:name)LIMIT 1;');
    $data->bind_param(':name', $name);
    $data->execute();
    $row=$data->fetch();

    //$sql="SELECT userID FROM users WHERE username='$name'";
    //$result=mysqli_query($db,$sql);
   // $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($data) == 1)
    {
        $searchID = $row['userID'];
        $data=$db -> prepare('SELECT title, photoID, url FROM photos WHERE userID= (:searchID)LIMIT 1;');
        $data->bind_param(':searchID', $searchID);
        $data->execute();
        
        //$searchID = $row['userID'];
        //$searchSql="SELECT title, photoID,url FROM photos WHERE userID='$searchID'";
        //$searchresult=mysqli_query($db,$searchSql);


        if(mysqli_num_rows($data)>0){
            while($searchRow = mysqli_fetch_assoc($data)){
                $line = "<p><img src='".$searchRow['url']."' style='width:100px;height:100px;'><a href='photo.php?id=".$searchRow['photoID']."'>".$searchRow['title']."</a></p>";
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