<?php
/* Reset your password form, sends reset.php password link */

include 'include/sendmailbasic.php';

require_once 'include/db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    
    $result = mysqli_query($con,"SELECT * FROM login WHERE email='$email'");
    $stmt=$con->prepare("SELECT * FROM `login` WHERE `email` = ?");
    $stmt->bind_param("s",$email);
    $email = $_POST['email'];
    $stmt->execute();
    $result= $stmt->get_result();
    if (  $result->num_rows == 0 ) // User doesn't exist
    {
        $_SESSION['message'] = "User with that email doesn't exist!";
        header('Location: ./forgot.php');
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $email = $user['email'];
        $username = $user['username'];
        $hash=$user['hash'];

        // Send Password Link confirmation link (reset.php)

        $to      = $email;
        $subject = 'Password Reset Link ( Veronica )';
        $message_body = '
        Hello '.$username.',

        You have requested password reset!

        Please click this link to reset your password:

        http://localhost/projects/finallogin/reset.php?email='.$email.'&hash='.$hash;

        if(email_std($to, $subject, $message_body))
        {
            $_SESSION['message'] = "Password reset link has been sent to email address!";
            header('Location: ./index.php');
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
