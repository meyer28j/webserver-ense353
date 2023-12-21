<?php
include 'api.php';
include 'menu.php';

$query = "SELECT movie_id FROM Movies";

$statement = dbConnect()->prepare($query);
$statement->execute();

$movies = $statement->fetchAll(PDO::FETCH_ASSOC);

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
      <br>
      <h2>Welcome</h2>
      <h1>Subscribe and keep up to date on your favourite movies.</h1>
      <p>NOTE: all resources used on this website are taken from <a href="https://www.themoviedb.org" target="_blank" rel="noopener noreferrer">themoviedb.org</a> and are being used explicitly for educational purposes.</p>
      <p>You must <a href="/login.php">Login</a> before you can subscribe to any movies.
    </div>
  </body>
</html>
