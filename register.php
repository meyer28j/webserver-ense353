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
        <form action="processRegister.php" method="post">
            <div class="row">
                <div class="six columns">
                    <label for="usernameInput">Username</label>
                    <input class="u-full-width" type="text" id="usernameInput" name="username">
                </div>
            </div>
             <div class="row">
                <div class="six columns">
                    <label for="emailInput">Email</label>
                    <input class="u-full-width" type="email" id="emailInput" name="email">
                </div>
            </div>
              <div class="row">
                 <div class="six columns">
                     <label for "passwordInput">Password</label>
                     <input class="u-full-width" type="password" id="passwordInput" name="password">
                 </div>
             </div>
             <div class="row">
                 <div class="six columns">
                     <label for "passwordVerifyInput">Re-type Password</label>
                     <input class="u-full-width" type="password" id="passwordVerifyInput" name="passwordVerify">
                 </div>
             </div>
             <input class="button-primary" type="submit" value="Submit">
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </body>
</html>
