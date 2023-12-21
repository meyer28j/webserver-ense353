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
    <title>Your Subscriptions</title>
    <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
  </head>
  
  <body>

    <?php
    include 'menu.php';
    include 'api.php';

    // get all movie IDs that the user is subscribed to

    $user = find_user_by_username($_SESSION['username']);
    $subscriptions = get_user_subscriptions($user['user_id']);

    if (!empty($subscriptions)) {

      // convert subscriptions into a single csv string
      // for SQL query WHERE clause
      $subscriptions_csv = "";
      for ($i = 0; $i < sizeof($subscriptions); $i++) {
        $subscriptions_csv .= $subscriptions[$i] . ",";
      }
      // delete last comma in csv
      $subscriptions_csv = rtrim($subscriptions_csv, ",");
      /*
      $query = "SELECT Movies.movie_id FROM Movies
              LEFT JOIN Subscriptions ON Movies.movie_id = Subscriptions.movie_id
              WHERE (Movies.movie_id IN (:subscriptions_csv))
                AND (Subscriptions.user_id = :user_id)";
       */
      $query = "SELECT movie_id FROM Subscriptions
                WHERE user_id = :user_id";
      print_r($subscriptions_csv);
      print_r($query);

      $statement = dbConnect()->prepare($query);
      // $statement->BindValue(':subscriptions_csv', $subscriptions_csv);
      $statement->BindValue(':user_id', $user['user_id']);
      print_r($statement);
      $statement->execute();

      $movies = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    ?>

    <div class="container u-max-full-width">
      <h1>Your Subscriptions</h1>
      <p>These are all the movies you have subscribed to. <a href="/movies.php">Click Here</a> to return to unsubscribed movies.</p>
      <br>
      <h2>Click On A Movie To View More Info</h2>
      <div class="flex-container">

        <?php
        if (empty($subscriptions)) {
          echo "<h2>What's That? You're Not Subscribed To Any Movies?</h2>";
          echo "<h3>What are you waiting for? Go check out some of our <a href='/movies.php'>Movies</a>!</h3>";
        } else {

        // for each movie, get the poster image
          for ($i = 0; $i < sizeof($movies); $i++) {
        ?>
          <div class="flex-item overlay-container">
          <a href="/movie-details.php?movie_id=<?php echo $movies[$i]['movie_id']; ?>">
            <img class="overlay-image" src="<?php echo get_poster_path($movies[$i]['movie_id']); ?>">
          </a>
          <div class="overlay-middle">
            <form action="/movie-details.php" method="GET">
               <input type="hidden" name="movie_id" value="<?php echo $movies[$i]['movie_id']; ?>">
              <input type="submit" class="button-primary overlay-middle" value="Movie Details">
              </form>
          </div>
          <div class="overlay-bottom">
            <form action="/unsubscribe.php" method="GET">
              <input type="hidden" name="movie_id" value="<?php echo $movies[$i]['movie_id']; ?>">
              <input type="submit" class="button-cancel overlay-bottom" value="Unsubscribe">
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
