<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Login Page</title>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) { //user logging in

        require './login.php';

    }

    elseif (isset($_POST['register'])) { //user registering

        require './register.php';

    }
}
?>

<body>
  <h1>Welcome!</h1>

  <form action="index.php" method="post">
    <label>Username</label>
    <input type="text" required name="username" />

    <label>Password</label>
    <input type="password" required name="password" />
    <p><a href="forgot.php">Forgot Password?</a></p>

    <button type="submit" name="login"/>Log In</button>

  </form>

  <h1>Sign Up for Free</h1>

  <form action="index.php" method="post" enctype="multipart/form-data">

    <label for="name">Name</label>
    <input type="text" required name='name' /><br>

    <label for="username">Username</label>
    <input type="text" required name='username' /><br>

    <label for="email">Email Address</label>
    <input type="email" required name='email' /><br>

    <label for="password">Password</label>
    <input type="password" required name='password' /><br>

    <label for="image">Display Picture</label>
    <input type="file" name="image"><br>

    <button type="submit" name="register" />Register</button>

  </form>

</body>

</html>
