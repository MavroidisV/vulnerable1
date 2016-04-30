<?php
	include("check.php");
    include("connection.php");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<h4>Welcome <?php echo $login_user;?> <a href="photos.php" style="font-size:18px">Photos</a>||<a href="searchphotos.php" style="font-size:18px">Search</a>||<a href="logout.php" style="font-size:18px">Logout</a></h4>
<div id="photo">
    <?php
        if(isset($_GET['id'])){
            $photoID = $_GET['id'];

            //Check username from db
            if (!($data=$db->prepare("SELECT photoID, title, description, postDate, url, userID FROM photos WHERE photoID=?;")))
            {echo "fail";}

            if(!$data->bind_param('s',$photoID)) {
                echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
            }

            if (!$data -> execute()){
                echo "Execute failed: (" . $data->errno . ") " . $data->error;
            }

            //$data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it
            
            /* Bind results to variables */
            $data->bind_result($photoID, $title, $description, $postDate, $url, $userID);
            //if ($data->num_rows = "1")
           // {
                /* Bind the result to variables */
                //$data->bind_result($id,$title,$description,$postDate,$url,$userID);

            /* fetch values */
            while ($data->fetch()) {
               // printf("%s %s\n", $photoID, $url);
                echo "<h1>".$title."</h1>";
                echo "<h3>".$postDate."</h3>";
                echo "<img src='".$url."'/>";
                echo " <p>".$description."</p>";

            }

            /* Close the statement */
            $data->close();

                //$row=$data->fetch();

                //$photoSql="SELECT * FROM photos WHERE photoID='$photoID'";
           // $photoresult=mysqli_query($db,$photoSql) or die(mysqli_error($db));
           // if(mysqli_num_rows($photoresult)==1){
                //$photoRow = mysqli_fetch_assoc($photoresult);
               // echo "<h1>".$row['title']."</h1>";
               // echo "<h3>".$row['postDate']."</h3>";
               // echo "<img src='".$row['url']."'/>";
               // echo " <p>".$row['description']."</p>";




    //Check username from db
    if (!($data=$db->prepare("SELECT * FROM comments WHERE photoID=?;")))
    {echo "fail";}

    if(!$data->bind_param('s',$photoID)) {
        echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
    }

    if (!$data -> execute()){
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    //$data->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it

    /* Bind results to variables */
    $data->bind_result($commentID, $description, $postDate, $url, $photoID);
    if ($data->num_rows > "1"){
    // {
    /* Bind the result to variables */
    //$data->bind_result($id,$title,$description,$postDate,$url,$userID);

    /* fetch values */
    while ($data->fetch()) {





                //$commentSql="SELECT * FROM comments WHERE photoID='$photoID'";
               // $commentresult=mysqli_query($db,$commentSql) or die(mysqli_error($db));
              //  if(mysqli_num_rows($commentresult)>1) {

                    echo "<h2> Comments </h2>";
                   // while($commentRow = mysqli_fetch_assoc($commentresult)){
                        echo "<div class = 'comments'>";
                        echo "<h3>".$postDate['postDate']."</h3>";
                        echo "<p>".$commentID['description']."</p>";
                        echo "</div>";
                    }

                }
                echo "<a href='addcommentform.php?id=".$photoID."'> Add Comment</a><br>";

                if($adminuser){
                    echo "<div class='error'><a href='removephoto.php?id=".$photoID."'> Delete Photo</a></div>";
                }

            }
          //  else{
              //  echo "<h1>No Photos Found</h1>";
           // }

      // }
    else{

        echo "<h1>No User Selected</h1>";
    }

    ?>
</div>

</body>
</html>
