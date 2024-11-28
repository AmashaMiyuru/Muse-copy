<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Include database and user class files
require_once '../classes/dbh.classes.php';
require_once '../classes/user.classes.php';

// Create an instance of User
$user = new User();

// Get the updated data from the form
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$address = htmlspecialchars($_POST['address']);
$contactNumber = htmlspecialchars($_POST['contactNumber']);
$userId = $_SESSION['userid'];

// Input validation
if (empty($username) || empty($email) || empty($address) || empty($contactNumber)) {
    header("Location: profile.php?error=emptyfields");
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: userprofile.php?error=invalidemail");
    exit();
}

// Check if the new username already exists
if ($user->usernameExists($username, $userId)) {
    header("Location: profile.php?error=usernameexists");
    exit();
}

// Update the user profile
if ($user->updateUserProfile($userId, $username, $email, $address, $contactNumber)) {
    // Update session data
    $_SESSION['username'] = $username;
    $_SESSION['useremail'] = $email;
    $_SESSION['useraddress'] = $address;
    $_SESSION['userphone'] = $contactNumber;

    // Redirect to profile page with success message
    header("Location: userprofile.php?success=profileupdated");
    exit();
} else {
    // Handle failure
    header("Location: userprofile.php?error=updatefailed");
    exit();
}
?>
