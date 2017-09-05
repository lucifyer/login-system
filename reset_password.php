<?php
/* Password reset process, updates database with new user password */
session_start();

require_once './db.php';


function unique_salt() {
    return substr(sha1(mt_rand()),0,22);
}


// Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Make sure the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) {


        $new_password= crypt($_POST['newpassword'], '$2a$10$'.unique_salt());
        $new_hash=unique_salt();

        // We get $_POST['email'] and $_POST['hash'] from the session variables
        $email = mysqli_real_escape_string($con,$_SESSION['email']);
        $hash = mysqli_real_escape_string($con,$_SESSION['hash']);

        $sql = "UPDATE login SET password='$new_password', hash='$new_hash' WHERE email='$email'";

        if ( mysqli_query($con,$sql) )
        {

        $_SESSION['message'] = "Your password has been reset successfully! Please login to continue!";

        $message = "Your password has been reset successfully! Please login to continue!";
        echo "<script>alert('$message');</script>";
        header('Refresh:0;url=./index.php');

        }

    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location: ./error.php");
    }

}
?>
