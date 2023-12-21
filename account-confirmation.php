<?php
session_start();
if (!isset($_GET["email"])) {
  header("Location: index.php");
  exit();
}
if ((isset($_SESSION["username"]) && $_SESSION["username"] != "") || !isset($_GET["email"])) {
  //   header("Location: index.php");
  //   exit();
  echo "<p>Would normally have redirected...</p>";
}

if (isset($_SESSION["username"]) && is_user_active(find_user_by_username($_SESSION['username']))) {
  // user is already activated
  header("Location: index.php");
  exit();
}

// include 'authenticate.php';

include 'menu.php';

// get email from $_GET

// resend activation link to email
$button_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    echo "Button pressed!";
    // button pressed to resend email

    $email = $_POST["email"];
    $activation_code = get_user_activation_code($email);
    send_activation_mail($email, $activation_code);
    $button_message = "Email sent.";

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  $email = $_GET["email"];

  if ($email == "" || $email == null) {
    // directed here "illegally" without email in get or post
    // header("Location: index.php");
    exit();
  }
}

/*
$connection = dbConnect();
if (!$connection) {
  exit();
}
try {
  $query = ("SELECT username, password FROM Users WHERE email='$email'");
  $result = $connection->query($query);
  if ($result <> null) { // valid username found
    // $info = $result->fetch();
    $query = ("UPDATE Users SET email_confirmed='1' WHERE email='$email'");
    $connection->query($query);
    // header("Location: index.php");
    echo "Email Confirmed";
    exit();
  } else {
    echo "ERROR: No user account registered for $email";
  }
} catch (PDOException $e) {
  echo "Error in account registration: " . $e->getMessage();
}
*/

?>

  <!DOCTYPE html>
    <html lang="en">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Cache-Control" content="no-cache">
  <title>Verify Your Account</title>
  <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
  </head>
  <body>
  <h1>Verify Your Account</h1>
  <p>Oops! You still need to verify your account.</p>
  <p>We've sent you an email at <strong><?php echo $email; ?></strong></p>
  <p>Follow the link in the email to activate your account.</p>
  <!--
  <div class="container">
  <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
  <label for="resendButton">Didn't get an email?</label>
          <input id="resendButton" class="button-primary" type="submit" value="Resend Email">
          <include type="hidden" name="email" value="<?php echo $email; ?>">
          <p class="error"><?php echo $button_message; ?></p>
        </form>
      </div>
    -->
    </body>
</html>
