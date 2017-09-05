<?php
/* Verifies registered user email, the link to this page
   is included in the register.php email message
*/
session_start();
require_once './db.php';



// Make sure email and hash variables aren't empty
if(isset($_GET['email']) && !empty($_GET['email']))
{
    $email = mysqli_real_escape_string($con,$_GET['email']);

    // Select user with matching email and hash, who hasn't verified their account yet (active = 0)
    $result = mysqli_query($con,"SELECT * FROM login WHERE email='$email' AND verified='0'");

    if ( mysqli_num_rows($result) == 0 )
    {
      $message = "Account has already been verified!";
      echo "<script>alert('$message');</script>";
      header('Refresh:0;url=./index.php');
    }
    else {
        $message = "Your account has been activated!";
        echo "<script>alert('$message');</script>";


        // Set the user status to active (active = 1)
        mysqli_query($con,"UPDATE login SET verified='1' WHERE email='$email'") or die(mysqli_error($con));

        echo '<script>window.close();</script>';
    }
}
else {


    $message = "Invalid parameters provided for account verification!";
    echo "<script>alert('$message');</script>";
    header('Refresh:0;url=./index.php');
}
?>
