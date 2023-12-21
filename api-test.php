<?php

// This is a test page to display JSON results
// from themoviedb.org API queries using the
// movie IDs in their database

session_cache_limiter('nocache');

include "api.php";
include "menu.php";

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Homepage</title>
    <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div class="container u-max-full-width">


    <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
        <label for="movie_id">Enter a Movie ID:</label>
        <input type="text" id="movie_id" name="movie_id">
        <input class="button-primary" type="submit" value="Submit">
    </form>
    </div>

<?php
      // default info to empty, populate if form
    // was submitted
    $info = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $info = get_movie_info($_POST["movie_id"]);
       embed_trailer($_POST["movie_id"]);
       echo "<img src=" . get_poster_path($_POST["movie_id"]) . ">";
    }
    echo "<pre>";
    print_r($info);
    echo "</pre>";
?>
