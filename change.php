<?php
/* Reset your password form, sends reset.php password link */

include './sendmailbasic.php';

session_start();
require_once './db.php';


// Check if form submitted with method="post"

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    if( isset($_SESSION['username']) && !empty($_SESSION['username']) AND isset($_SESSION['logged_in']) && !empty($_SESSION['logged_in']) ) //Check if user is logged in
    {
      $result = mysqli_query($con,"SELECT * FROM login WHERE username='$_SESSION[username]'");

      $user = mysqli_fetch_assoc($result); // $user becomes array with user data

      if(crypt($_POST['password'],$user['password']) == $user['password'])
      {
        $address='http://localhost/projects/finallogin/reset.php?email='.$user['email'].'&hash='.$user['hash'];
        header("location: $address");
    }
    else {
      echo "incorrect password! Try again!";
    }
  }
  else {
    $_SESSION['message'] = "Forbidden";
    header("location: ./error.php");
  }


}
?>


<?php

    if(isset($_SESSION['logged_in']))
    {

?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
</head>

<body>

    <h1>Change your password</h1>

    <form action="change.php" method="post">
      <label>Current password<span>*</span></label>
      <input type="password" required name="password"/>
    <input type="submit" value="Change"/>
    </form>

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
