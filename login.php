<?php
session_start();
if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
    header("Location: index.php");
    exit();
}
// include 'authenticate.php';
include 'menu.php';
$usernameError = $passwordError = "";
$username = $password = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]))
        $usernameError = "Username is required";
    else
        $username = trim_input($_POST["username"]);
    if (empty($_POST["password"]))
        $passwordError = "password is required";
    else
        $password = trim_input($_POST["password"]);

    // use error messages as flags; all messages clear == all valid input
    if (empty($usernameError) && empty($passwordError)) {
        $info = find_user_by_username($username);
        if ($info["username"] == $username) {
            if ($info["password"] == $password) {
                if ($info["active"] == 0) { // trying to login with inactive account
                    // redirect to verification page with email in $_GET
                    header("Location: account-confirmation.php?email=".$info["email"]);
                    exit();
                }
                $_SESSION["username"] = $username;
                header("Location: movies.php"); // normal login, account active
                exit();
            } else {
                $passwordError = "Incorrect password";
            }
        } else {
            $usernameError = "Incorrect username";
        }
    }

}
?>

    <!DOCTYPE html>
        <html lang="en">
                               <head>
                               <meta charset="UTF-8">
                               <meta name="viewport" content="width=device-width, initial-scale=1.0">
                               <meta http-equiv="X-UA-Compatible" content="ie=edge">
                               <meta http-equiv="Cache-Control" content="no-cache">
                               <title>Login</title>
                               <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
                               <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
                               <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
                               </head>
                               <body>
<?php // include 'menu.php';
                               ?>
                               <div class="container">
                               <h1>Login</h1>
                               <p>Enter your information below to log in,</p>
                               <p>or <a href="register.php">Register</a> a new account</p>
                               <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
                               <div class="row">
                               <div class="six columns">
                               <label for="usernameInput">Username</label>
        <input class="u-full-width" type="text" id="usernameInput" name="username" value=<?php echo $username; ?> >
        <span class="error">* <?php echo $usernameError;?></span>
            <br>
            </div>
            </div>
            <div class="row">
                               <div class="six columns">
                               <label for "passwordInput">Password</label>
            <input class="u-full-width" type="password" id="passwordInput" name="password" value=<?php echo $password; ?> >
            <span class="error">* <?php echo $passwordError;?></span>
                <br>
                </div>
                </div>
                <input class="button-primary" type="submit" value="Submit">
                               </form>
                               </div>
                               </body>
                               </html>
