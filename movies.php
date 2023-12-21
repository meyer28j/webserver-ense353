<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Movies</title>
    <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
  </head>
  
  <body>

    <?php
    include 'menu.php';
    include 'api.php';

    // get all movie IDs that the user
    // isn't subscribed to

    $user = find_user_by_username($_SESSION['username']);
    $subscriptions = get_user_subscriptions($user['user_id']);

    // convert subscriptions into a single csv string
    // for SQL query WHERE clause
    $subscriptions_csv = "";
    for ($i = 0; $i < sizeof($subscriptions); $i++) {
      $subscriptions_csv .= $subscriptions[$i] . ",";
    }
    // delete last comma in csv
    $subscriptions_csv = rtrim($subscriptions_csv, ",");


    $query = "SELECT DISTINCT Movies.movie_id FROM Movies";

    // exclude subscriptions
    if (!empty($subscriptions)) {
      $query .= " LEFT JOIN Subscriptions ON Movies.movie_id = Subscriptions.movie_id
                WHERE (Movies.movie_id NOT IN ($subscriptions_csv))";
    }

    //$query = "SELECT movie_id FROM Subscriptions
    //          WHERE movie_id NOT IN (:subscriptions_csv)
    //            AND user_id = :user_id";

    $statement = dbConnect()->prepare($query);
//    $statement->bindvalue(':subscriptions_csv', $subscriptions_csv);
    // $statement->bindValue(':user_id', $user['user_id']);
    $statement->execute();

    $movies = $statement->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <div class="container u-max-full-width">
      <h1>Movies</h1>
      <p>This is where you can find and subscribe to all the movies on our site.</p>
      <p>You can see all the movies you've subscribed to in the <a href="/subscriptions.php">Subscriptions</a> page.</p>
      <br>
      <h2>Click On A Movie To Subscribe</h2>
      <div class="flex-container">

        <?php
        // if all movies are subscribed to
        if (empty($movies)) {
          echo "<h3>What's That? You've Subscribed To Every Movie We Offer?</h3>";
          echo "<h2>WOW!!! You get a <span style='color: #E5E232;'>GOLD STAR</span></2>";
          echo "<img src='/res/goldstar.jpg' width=500px height=500px>";
        } else {

        // for each movie, get the poster image
        for ($i = 0; $i < sizeof($movies); $i++) {
        ?>
          <div class="flex-item overlay-container">
            <img class="overlay-image" src="<?php echo get_poster_path($movies[$i]['movie_id']); ?>">
            <div class="overlay-middle">
              <form action="/subscribe.php" method="GET">
                <input type="hidden" name="movie_id" value="<?php echo $movies[$i]['movie_id']; ?>">
                <input class="button-primary overlay-middle" type="submit" value="Subscribe">
              </form>
            </div>
          </div>
        <?php
        }
        }
        ?>
      </div>
    </div>
  </body>
</html>



