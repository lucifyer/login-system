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
        <title>Change Display Picture</title>
    </head>

    <body>
        <h1>Upload a photo!</h1>
        <img src="<?php echo $dp ?>" width="70px" height="80px" alt="error">
        <br>

        <form action="uploaddp.php" method="post" enctype="multipart/form-data">
            <label for="image">Display Picture</label>
            <br>
            <input type="file" required name="image">
            <br>
            <br>
            <input type="submit" name="upload" value="upload">

    </body>

    </html>


    <?php
} else {
    $_SESSION['message'] = "Please login to view this page!";
    header('Location: ./index.php');
}

?>