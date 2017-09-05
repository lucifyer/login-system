<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
session_start();

require_once './db.php';

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $_SESSION['email'] = mysqli_real_escape_string($con,$_GET['email']);
    $_SESSION['hash'] = mysqli_real_escape_string($con,$_GET['hash']);

    // Make sure user email with matching hash exist
    $result = mysqli_query($con,"SELECT * FROM login WHERE email='$_SESSION[email]' AND hash='$_SESSION[hash]'");

    if ( mysqli_num_rows($result) == 0 )
    {
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        header("location: ./error.php");
    }
}
else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    header("location: ./error.php");
}
?>
<!DOCTYPE html>
<html >
<head>
  <title>Reset Your Password</title>
</head>

<body>
          <h1>Choose Your New Password</h1>

          <form action="reset_password.php" method="post">

            <label>New Password<span class="req">*</span></label>
            <input type="password" required name="newpassword"/>

            <label>
              Confirm New Password<span class="req">*</span>
            </label>
            <input type="password" required name="confirmpassword" />

          <input type="submit" value="reset"/>
          </form>
</body>
</html>
