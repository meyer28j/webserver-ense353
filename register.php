<?php
session_start();
if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
    header("Location: index.php");
    exit();
}
include 'menu.php';

// form-submitted variables are $username, $email, $password, $passwordVerify

$usernameError = $emailError = $passwordError = $passwordVerifyError = "";
$username = $email = $password = $passwordVerify = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]))
        $usernameError = "Username is required";
    else
        $username = trim_input($_POST["username"]);
    if (empty($_POST["email"]))
        $emailError = "Email is required";
    else
        $email =  trim_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $emailError = "Invalid email format";
    if (empty($_POST["password"]))
        $passwordError = "password is required";
    else
        $password = trim_input($_POST["password"]);
    if (empty($_POST["passwordVerify"]))
        $passwordVerifyError = "password verification is required";
    else
        $passwordVerify = trim_input($_POST["passwordVerify"]);

    if ($_POST["password"] != $_POST["passwordVerify"])
        $passwordVerifyError = "passwords do not match";

    // use error messages as flags; all messages clear == all valid input
    if (empty($usernameError) &&
        empty($emailError) &&
        empty($passwordError) &&
        empty($passwordVerifyError)) {

        // generate and send an activation code to
        // the submitted email
        try {
            $activation_code = generate_activation_code();
            $is_admin = 0;
            register_user($username, $email, $password, $activation_code, $is_admin);

            send_activation_mail($email, $activation_code);

            header("Location:account-confirmation.php?email=$email");
            exit();
        } catch (PDOException $e) {
            echo "Error in account registration: " . $e->getMessage();
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
                               <title>Registration</title>
                               <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
                               <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
                               <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
                               </head>
                               <body>
<?php // include 'menu.php';
                               ?>
                               <div class="container">
                               <h1>Registration</h1>
                               <p>HUGE shoutout to phptutorial.net for their email verification tutorial; it powers much of this process.</p>
                                   <p>Already have an account? <a href="login.php">Login</a></p>
                                                                                                                                        <p>To register a new account, fill out the form below:</p>
                                                                                                                                        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
                                                                                                                                        <div class="row">
                                                                                                                                        <div class="six columns">
                                                                                                                                        <label for="usernameInput">Username</label>
                                                                                                                                        <input class="u-full-width" type="text" id="usernameInput" name="username" value=<?php echo $username;?>>
                                   <span class="error">* <?php echo $usernameError;?></span>
                                       <br><br>
                                       </div>
                                       </div>
                                       <div class="row">
                                                                                                                                        <div class="six columns">
                                                                                                                                        <label for="emailInput">Email</label>
                                                                                                                                        <input class="u-full-width" type="email" id="emailInput" name="email" value=<?php echo $email;?>>
                                       <span class="error">* <?php echo $emailError;?></span>
                                           <br><br>
                                           </div>
                                           </div>
                                           <div class="row">
                                                                                                                                        <div class="six columns">
                                                                                                                                        <label for "passwordInput">Password</label>
                                                                                                                                        <input class="u-full-width" type="password" id="passwordInput" name="password" value=<?php echo $password;?>>
                                           <span class="error">* <?php echo $passwordError;?></span>
                                               <br><br>
                                               </div>
                                               </div>
                                               <div class="row">
                                                                                                                                        <div class="six columns">
                                                                                                                                        <label for "passwordVerifyInput">Re-type Password</label>
                                                                                                                                        <input class="u-full-width" type="password" id="passwordVerifyInput" name="passwordVerify" value=<?php echo $passwordVerify;?>>
                                               <span class="error">* <?php echo $passwordVerifyError;?></span>
                                                   <br><br>
                                                   </div>
                                                   </div>
                                                   <input class="button-primary" type="submit" name="submit" value="Submit">
                                                                                                                                        </form>
                                                                                                                                        </div>
                                                                                                                                        </body>
                                                                                                                                        </html>
