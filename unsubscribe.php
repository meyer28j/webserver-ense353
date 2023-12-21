<?php


// this is a script that REMOVES a movie
// ID passed in via GET to the active
// user's subscription list

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["username"]) ||
    $_SESSION["username"] == "" ||
    !isset($_GET["movie_id"]))
{
    header("Location: index.php");
    exit();
}

include "authenticate.php";
include "api.php";

$user = find_user_by_username($_SESSION["username"]);

// verify that ONLY ONE subscription matches the
// movie ID for this user
$query = "SELECT * FROM Subscriptions
          WHERE movie_id = :movie_id
            AND user_id = :user_id";

$statement = dbConnect()->prepare($query);
$statement->bindValue(':movie_id', $_GET['movie_id']);
$statement->bindValue(':user_id', $user['user_id']);
$statement->execute();

if ($statement->rowCount() > 1) {
    // more than one movie to unsubcribe identified
    // meaning something is wrong in the database
    // (likely duplicate entries with same user ID
    // and movie ID)
    header("Location: movies.php");
    exit();
}

$query = "DELETE FROM Subscriptions
          WHERE user_id = :user_id AND movie_id = :movie_id";

$statement = dbConnect()->prepare($query);
$statement->bindValue(':movie_id', $_GET['movie_id']);
$statement->bindValue(':user_id', $user['user_id']);
$statement->execute();

header("Location: subscriptions.php");
exit();
