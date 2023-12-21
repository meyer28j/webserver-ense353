<?php
session_start();

if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
    // user already logged in and illegally navigated here
    header("Location: index.php");
    exit();
}

// include 'authenticate.php';

include 'menu.php';

$user = find_inactive_user($_GET['email'], $_GET['activation_code']);

if ($user && activate_user($user['user_id'])) {
    $_SESSION['username'] = $user['username'];

    echo "<h2>Account Registered Successfully!</h2>";
    echo "<p>Return to <a href='https://meyer.ursse.org/index.php'>Home</a></p>";

} else {

    echo "<h2>Something went wrong!</h2>";
    echo "<p>It's likely an error in retrieving user info from the database, or if you are trying to activate an already activated account.</p>";
}

?>
