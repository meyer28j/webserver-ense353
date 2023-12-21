<?php

session_start();
if (!isset($_SESSION["username"]) ||
    !isset($_GET["movie_id"])) {
    header("Location: index.php");
    exit();
}

include "api.php";

$movie_id = $_GET['movie_id'];

$movie_info = get_movie_info($movie_id);

?>
    <html>
        <head>
        <meta charset="utf-8">
            <title>Movie Details</title>
            <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
            <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
            <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
            </head>

            <body>
<?php include 'menu.php';?>
            <div class="container">
            <br>
            <h2><?php echo $movie_info['title']; ?></h2>

                <h3>Overview</h3>
                <p><?php echo $movie_info['overview']; ?></p>
                    <br>
                    <br>
                    <h3>Poster</h3>
<?php embed_poster($movie_id); ?>
                    <br>
                    <br>
                    <h3>Trailer</h3>
<?php embed_trailer($movie_id); ?>
                    <br>
                    <br>
                    <form action="/unsubscribe.php" method="GET">
            <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
            <input type="submit" class="button-cancel" value="Unsubscribe">
            </form>
            <p>After unsubscribing from this movie, you can resubscribe any time.</p>

                    <a href="/subscriptions.php">Return To Your Subscriptions</a>
            </div>
            </body>
            </html>
