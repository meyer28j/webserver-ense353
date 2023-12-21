<?php

session_start();

// verify user is logged in
if (!isset($_SESSION['username']))
{
    header("Location: index.php");
    exit();
}

// include 'authenticate.php';
include 'menu.php';

// verify user has admin privileges
$user = find_user_by_username($_SESSION['username']);

if (!$user || !(is_user_active($user))) {
    header("Location: index.php");
    exit();
}

// user verified to be admin

// when user submits the password change
// form, it POSTS to this page with the
// user_id and password
if (isset($_POST['user_id']) && isset($_POST['password'])) {
    $result = change_user_password($_POST['user_id'], $_POST['password']);
    if ($result == false) {
            $_POST['message'] = "No users found with that ID";
        }
}

header("Location: backrooms.php");
exit();

?>
