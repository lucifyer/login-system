<?php
session_start();

if (isset($_SESSION['message']) and !empty($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);}

if (isset($_SESSION['logged_in'])) {
    if ($_SESSION['image'] == '') {
        $dp = 'images/default.png';
    } else {
        $dp = $_SESSION['image'];
    }

    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Profile</title>
    </head>

    <body>
        <h1>Hey
            <?php echo $_SESSION['username'] ?>
        </h1>
        <img src="<?php echo $dp ?>" width="70px" height="80px" alt="error">
        <br>

        <a href="./change.php">Change your password</a>
        <a href="./changedp.php">Change your display picture</a>
        <a href="./logout.php">Logout</a>
    </body>

    </html>
    <?php
} else {
    $_SESSION['message'] = "Please login to view this page!";
    header('Location: ./index.php');
}

?>