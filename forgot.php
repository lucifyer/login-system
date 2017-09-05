<?php
/* Reset your password form, sends reset.php password link */

include './sendmailbasic.php';

require_once './db.php';


// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $result = mysqli_query($con,"SELECT * FROM login WHERE email='$email'");

    if (  mysqli_num_rows($result) == 0 ) // User doesn't exist
    {
        $message = "User with that email doesn't exist!";
        echo "<script>alert('$message');</script>";
        header('Refresh:0;url=./forgot.php');
    }
    else { // User exists (num_rows != 0)

        $user = mysqli_fetch_assoc($result); // $user becomes array with user data

        $email = $user['email'];
        $username = $user['username'];
        $hash=$user['hash'];


        // Send registration confirmation link (reset.php)

        $to      = $email;
        $subject = 'Password Reset Link ( Veronica )';
        $message_body = '
        Hello '.$username.',

        You have requested password reset!

        Please click this link to reset your password:

        http://localhost/projects/finallogin/reset.php?email='.$email.'&hash='.$hash;

        if(email_std($to, $subject, $message_body))
        {
            $message = "Password reset link has been sent to email address!";
            echo "<script>alert('$message');</script>";
            header('Refresh:0;url=./index.php');
        }

    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
</head>

<body>


    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">
      <label>Email Address<span>*</span></label>
      <input type="email" required name="email"/>
    <input type="submit" value="Reset"/>
    </form>

</body>

</html>
