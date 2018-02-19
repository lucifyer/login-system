<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST['upload']))
        {
            require_once './db.php';

            //This is the directory where images will be saved
            $target = "images/";
            $target = $target . $_SESSION['username'] . '.jpg';

            if(!move_uploaded_file($_FILES['image']['tmp_name'], $target))
            {
                //Checks if there was problem uploading it to server
                echo "There was problem uploading your image! Please try again with a different image after loggin in!<br>";

            }
            else {
                $query = "update login set image ='$target' where username ='".$_SESSION['username']."'";
                if(!mysqli_query($con,$query))
                {
                    echo "Error uploading your image try again!";
                    mysqli_error($con);
                }
                else {
                    $message = "Upload successful!";
                    $_SESSION['image']=$target;
                    echo "<script>alert('$message');</script>";
                    header('Refresh:0;url=profile.php');
                }

            }

        }

    }




    if(isset($_SESSION['logged_in']))
    {
        if($_SESSION['image']=='')
            $dp='images/default.png';
        else
            $dp=$_SESSION['image'];

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Change Display Picture</title>
  </head>
  <body>
      <h1>Upload a photo!</h1>
      <img src="<?php echo $dp ?>" width="70px" height="80px" alt="error"><br>

      <form action="changedp.php" method="post" enctype="multipart/form-data">
          <label for="image">Display Picture</label><br>
          <input type="file" required   name="image"><br><br>
      <input type="submit" name="upload" value="upload">

  </body>
</html>


<?php
    }
    else {
        $message = "Please login to view this page!";
        echo "<script>alert('$message');</script>";
        header('Refresh:0;url=./index.php');
    }

?>
