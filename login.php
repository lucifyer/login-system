<?php
/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
session_start();

require_once 'include/db.php';

$stmt = $con->prepare("SELECT * FROM `login` WHERE `username` = ?");
$stmt->bind_param("s", $username);
$username = $_POST['username'];
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) { // User doesn't exist
    $_SESSION['message'] = "No such username registered!";
    header('Location: index.php');
} else { // User exists

    $row = $result->fetch_assoc();

    if (password_verify($_POST['password'], $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['image'] = $row['image'];
        // This is how we'll know the user is logged in

        $_SESSION['logged_in'] = true;
        header("location: profile.php");
    } else {
        $_SESSION['message'] = "Wrong password";
        header('Location: index.php');
    }
}
