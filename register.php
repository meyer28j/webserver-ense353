<?php
    // variables are $username, $email, $password, $passwordVerify

    $usernameError = $emailError = $passwordError = $passwordVerifyError = "";
    $username = $email = $password = $passwordVerify = "";

    function trim_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["username"]))
                $usernameError = "Username is required";
            else
                $username = trim_input($_POST["username"]);
            if (empty($_POST["email"]))
                $emailError = "Email is required";
            else
                $email =  trim_input($_POST["email"]);
             if (empty($_POST["password"]))
                $passwordError = "password is required";
             else
                $password = trim_input($_POST["password"]);
             if (empty($_POST["passwordVerify"]))
                $passwordVerifyError = "password verification is required";
             elseif ($_POST["password"] != $_POST["passwordVerify"])
                $passwordVerifyError = "passwords do not match";
             else
                $passwordVerify = trim_input($_POST["passwordVerify"]);
    }
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <h1>Registration</h1>
    <p>I WILL BECOME THE BEST REGISTRATION PAGE IN THE WORLD</p>
    <div class="container">
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
            <input class="u-full-width" type="password" id="passwordInput" name="password">
             <span class="error">* <?php echo $passwordError;?></span>
            <br><br>
          </div>
        </div>
        <div class="row">
          <div class="six columns">
            <label for "passwordVerifyInput">Re-type Password</label>
            <input class="u-full-width" type="password" id="passwordVerifyInput" name="passwordVerify">
            <span class="error">* <?php echo $passwordVerifyError;?></span>
            <br><br>
          </div>
        </div>
        <input class="button-primary" type="submit" name="submit" value="Submit">
      </form>
      <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
  </body>
</html>
