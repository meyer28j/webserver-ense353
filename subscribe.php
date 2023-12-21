<?php

// this is a script that adds a movie
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

// verify that user is not already subscribed
$query = "SELECT * FROM Subscriptions
          WHERE movie_id = :movie_id
            AND user_id = :user_id";

$statement = dbConnect()->prepare($query);
$statement->bindValue(':movie_id', $_GET['movie_id']);
$statement->bindValue(':user_id', $user['user_id']);
$statement->execute();

if ($statement->rowCount() > 0) {
    // already subscribed, got here illegally somehow
    header("Location: movies.php");
    exit();
}

$query = "INSERT INTO Subscriptions (user_id, movie_id)
          VALUES (" . $user['user_id'] . ", " . $_GET['movie_id'] . ")";

$statement = dbConnect()->prepare($query);
$statement->execute();

header("Location: movies.php");
exit();
