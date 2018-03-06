<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Login Page</title>

  <script>
    //To check wether both the passwords are same
    function validate() {
      if (document.getElementById('password').value == document.getElementById('password2').value)
        return true;
      else {
        alert('Passwords do not match!');
        return false;
      }
    } 
  </script>

</head>


<body>

  <?php
session_start();

if (isset($_SESSION['message']) and !empty($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);}

?>

    <h1>Welcome!</h1>

    <form action="login.php" method="post">
      <label>Username</label>
      <input type="text" required name="username" />

      <label>Password</label>
      <input type="password" required name="password" />
      <p>
        <a href="forgot.php">Forgot Password?</a>
      </p>

      <button type="submit" name="login" />Log In</button>

    </form>

    <h1>Sign Up for Free</h1>

    <form action="register.php" onsubmit="return validate()" method="post" enctype="multipart/form-data">

      <label for="name">Name</label>
      <input type="text" required name='name' />
      <br>

      <label for="username">Username</label>
      <input type="text" required name='username' />
      <br>

      <label for="email">Email Address</label>
      <input type="email" required name='email' />
      <br>

      <label for="password">Password</label>
      <input type="password" required name='password' id="password" />
      <br>

      <label for="password2">Re-enter Password</label>
      <input type="password" required name='password2' id="password2" />
      <br>

      <label for="image">Display Picture</label>
      <input type="file" name="image">
      <br>

      <button type="submit" name="register" />Register</button>

    </form>

</body>

</html>