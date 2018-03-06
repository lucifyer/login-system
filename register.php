<?php
/* Registration process, inserts user info into the database
and sends account confirmation email message
 */

include 'include/sendmailbasic.php';
//Random salt generator
function unique_salt()
{
    return substr(sha1(mt_rand()), 0, 22);
}

session_start();

require_once 'include/db.php';

// Check if user with that email already exists

$stmt = $con->prepare("SELECT * FROM `login` WHERE `email` = ?");
$stmt->bind_param("s", $email);
$email = $_POST['email'];
$stmt->execute();
$result = $stmt->get_result();

// We know email exists if the rows returned are more than 0
if ($result->num_rows > 0) {
    $_SESSION['message'] = "User with this email already exists!";

    header('Location: ./index.php');
    die();
}

// Check if user with that username already exists

$stmt = $con->prepare("SELECT * FROM `login` WHERE `username` = ?");
$stmt->bind_param("s", $username);
$username = $_POST['username'];
$stmt->execute();
$result = $stmt->get_result();

// We know  username exists if the rows returned are more than 0
if (mysqli_num_rows($result) > 0) {
    $_SESSION['message'] = "User with this username already exists!";
    header('Location: ./index.php');
    
} else {
    // username doesn't already exist in a database, proceed...

    //This is the directory where images will be saved
    $target = "./images/";
    $target = $target . $username . '.jpg';

    if (!empty($_FILES['image']['tmp_name'])) {
        //Writes the Filename to the server
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            //Checks if there was problem uploading it to server
            echo "There was problem uploading your image! Please try again with a different image after loggin in!<br>";
            $target = '';
        }
    } else {
        $target = '';
    }

    $stmt = $con->prepare("INSERT INTO `login` VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $username, $name, $email, $password, $verified, $hash, $target);

    $verified = 0;
    $name = $_POST['name'];
    $password = $_POST['password'];
    //Use Bycrypt method to one way encrypt the password before storing in database
    $password = password_hash($password, PASSWORD_BCRYPT);
    $hash = password_hash(unique_salt(), PASSWORD_BCRYPT);

    // Add user to the database
    if ($stmt->execute()) {

        // Send registration confirmation link (verify.php)
        $to = $email;
        $subject = 'Account Verification ( Veronica )';
        $message_body = '
        Hello ' . $name . ',

        Thank you for signing up!

        Please click this link to activate your account:

        http://localhost/projects/finallogin/verify.php?email=' . $email . '&hash=' . $hash;

        email_std($to, $subject, $message_body);

        $_SESSION['message'] = "Confirmation link has been sent to $email, please verify your account by clicking on the link in the message!";
        header('Location: ./index.php');

    } else {
        $_SESSION['message'] = "Registration failed! Try again!";
        header('Location: ./index.php');
    }

}
