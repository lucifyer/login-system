<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logged out</title>
</head>

<body>
    <div class="form">
          <h1>Thanks for stopping by</h1>

          <p>You have been logged out!</p>

          <a href="./index.php"><input type="button" value="Home"/></a>

    </div>
</body>
</html>
