<?php
/* Registration process, inserts user info into the database
   and sends account confirmation email message
 */

include './sendmailbasic.php';

//Random salt generator
 function unique_salt() {
     return substr(sha1(mt_rand()),0,22);
 }


 session_start();

 require_once './db.php';


// Escape all $_POST variables to protect against SQL injections

$name = mysqli_real_escape_string($con,$_POST['name']);
$username = mysqli_real_escape_string($con,$_POST['username']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$password= crypt($password, '$2a$10$'.unique_salt());
$hash=unique_salt();

//This is the directory where images will be saved
$target = "images/";
$target = $target . $username . '.jpg';


// Check if user with that email already exists
$result = mysqli_query($con,"SELECT * FROM login WHERE email='$email'");

// We know email exists if the rows returned are more than 0
if ( mysqli_num_rows($result) > 0 ) {
  $message = "User with this email already exists!";
  echo "<script>alert('$message');</script>";
  header('Refresh:0;url=./index.php');
  die();
}


// Check if user with that username already exists
$result = mysqli_query($con,"SELECT * FROM login WHERE username='$username'");

// We know  username exists if the rows returned are more than 0
if ( mysqli_num_rows($result) > 0 ) {
  $message = "User with this username already exists!";
  echo "<script>alert('$message');</script>";
  header('Refresh:0;url=./index.php');
}

else {
  // username doesn't already exist in a database, proceed...

  if(!empty($_FILES['image']['tmp_name']))
  {
      //Writes the Filename to the server
      if(!move_uploaded_file($_FILES['image']['tmp_name'], $target))
      {
          //Checks if there was problem uploading it to server
          echo "There was problem uploading your image! Please try again with a different image after loggin in!<br>";
          $target='';
      }
  }
  else {
      $target='';
  }

    $sql = "INSERT INTO login(username,name,email,password,hash,image) VALUES ('$username','$name','$email','$password','$hash','$target')";

    // Add user to the database
    if ( mysqli_query($con,$sql) ){

        // Send registration confirmation link (verify.php)
        $to      = $email;
        $subject = 'Account Verification ( Veronica )';
        $message_body = '
        Hello '.$name.',

        Thank you for signing up!

        Please click this link to activate your account:

        http://localhost/projects/finallogin/verify.php?email='.$email.'&hash='.$hash;

        email_std( $to, $subject, $message_body );

        $message = "Confirmation link has been sent to $email, please verify your account by clicking on the link in the message!";
        echo "<script>alert('$message');</script>";
        header('Refresh:0;url=./index.php');

    }

    else {
      $message = "Registration failed! Try again!";
      echo "<script>alert('$message');</script>";
      header('Refresh:0;url=./index.php');
    }

}
