<?php

if (session_status() === PHP_SESSION_NONE) session_start();

include 'authenticate.php';
?>

<div class="container">
    <a href="/index.php">Home</a>

<?php
    // if user is not logged in, display "login" and "register"
if (!isset($_SESSION["username"])) { ?>

    <span class="u-pull-right"><a href="/login.php">Login</a> -
    <a href="/register.php">Register</a>

<?php
} else { // user is already logged in

    // if user is admin, display "admin" links
    $user = find_user_by_username($_SESSION['username']);

    if ($user && is_user_admin($user)) {
    ?>
    <span> -
        <a href='/backrooms.php'>Admin</a>
    </span>
    <?php
    }
    // destroy user data in case it interferes with other php code
    // as this menu is 'included' in other pages
    $user = null;

    /* display username and "logout" button */
?>
    <span> -
        <a href="/movies.php">Movies</a> -
        <a href="/subscriptions.php">My Subscriptions</a>
    </span>
    <span class="u-pull-right">Hello <?php echo $_SESSION["username"]; ?>! -
        <a href="/logout.php">Logout</a>
    </span>
<?php
}
?>
</div>
