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

// when user hits 'delete' button, it
// POSTS to this page with the user_id
if (isset($_POST['user_id'])) {
    delete_user_by_id($_POST['user_id']);
}

header("Location: backrooms.php");
exit();

?>
