<?php
/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
session_start();

require_once 'db.php';

$username = mysqli_real_escape_string($con,$_POST['username']);
$result = mysqli_query($con,"SELECT * FROM login WHERE username='$username'");

if ( mysqli_num_rows($result) == 0 ){ // User doesn't exist
  $message = "No such username registered!";
  echo "<script>alert('$message');</script>";
  header('Refresh:0;url=index.php');
}
else { // User exists
    $user = mysqli_fetch_assoc($result);

    if (password_verify($_POST['password'],$user['password']))
     {
        $_SESSION['username'] = $user['username'];
        $_SESSION['image'] = $user['image'];
        // This is how we'll know the user is logged in

        $_SESSION['logged_in'] = true;
        header("location: profile.php");
    }
    else {
      $message = "Wrong password";
      echo "<script>alert('$message');</script>";
      header('Refresh:0;url=index.php');
    }
}
