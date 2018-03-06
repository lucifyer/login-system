<?php
/* The password reset form, the link to this page is included
from the forgot.php email message
 */
session_start();

require_once 'include/db.php';

// Make sure email and hash variables aren't empty
if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Make sure user email with matching hash exist

    $stmt = $con->prepare("SELECT * FROM `login` WHERE email = ? AND `hash`= ?");
    $stmt->bind_param("ss", $_SESSION['email'], $_SESSION['hash']);
    $_SESSION['email'] = $_GET['email'];
    $_SESSION['hash'] = $_GET['hash'];

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        header("location: ./index.php");
    }
} else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    header("location: ./index.php");
}
?>
  <!DOCTYPE html>
  <html>

  <head>
    <title>Reset Your Password</title>
  </head>

  <body>

    <?php

if (isset($_SESSION['message']) and !empty($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);}

?>
      <h1>Choose Your New Password</h1>

      <form action="reset_password.php" method="post">

        <label>New Password
          <span class="req">*</span>
        </label>
        <input type="password" required name="newpassword" />

        <label>
          Confirm New Password
          <span class="req">*</span>
        </label>
        <input type="password" required name="confirmpassword" />

        <input type="submit" value="reset" />
      </form>
  </body>

  </html>