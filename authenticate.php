<?php

// A suite of functions for authenticating
// a user

include 'dbConnect.php';


function find_user_by_username(string $username) {

    // IF SOMETHING BROKE, LOOK HERE
    // $query = 'SELECT username, email, password, active, admin
     $query = 'SELECT *
              FROM Users
              WHERE username=:username';

    $statement = dbConnect()->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}


function is_user_active($user) {

    return (int)$user['active'] === 1;
}

function is_user_admin($user) {
    return (int)$user['admin'] === 1;
}


function find_inactive_user(string $email, string $activation_code) {

    $query = 'SELECT user_id, username, email, activation_code
              FROM Users
              WHERE active = 0 AND email=:email';

    $statement = dbConnect()->prepare($query);

    $statement->bindValue(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if ($user && $user['activation_code'] == $activation_code) {
        // user found and activation_code matches from email
        return $user;
    }
    return null;
}


function login(string $username, string $password): bool {
    $user = find_user_by_username($username);

    if ($user && is_user_active($user) && $password_verify($password, $user['password'])) {
        // prevent session fixation attack. Oh my!
        session_regenerate_id();

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        return true;
    }
    return false;
}


function not_logged_in_redirect() {
    if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
        header("Location: index.php");
        exit();
    }
}


function register_user(string $username,
                       string $email,
                       string $password,
                       string $activation_code,
                       string $admin): bool {

    $query = 'INSERT INTO Users (username, email, password, active, activation_code, admin)
              VALUES (:username, :email, :password, 0, :activation_code, :admin)';

    $statement = dbConnect()->prepare($query);

    $statement->bindValue(':username', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':activation_code', $activation_code);
    $statement->bindValue(':admin', $admin);

    return $statement->execute();

}


function get_user_activation_code(string $email):string {

    $query = 'SELECT activation_code
              FROM Users
              WHERE email=:email';

    $statement = dbConnect()->prepare($query);
    $statement->bindValue(':email', $email);

    return $activation_code;
}

function generate_activation_code(): string {
    return bin2hex(random_bytes(16));
}

function send_activation_mail(string $email, string $activation_code): void {

    $activation_link = "https://meyer.ursse.org/activate-account.php?email=$email&activation_code=$activation_code";

    $subject = "Verify Your Account";
    $message = <<<MESSAGE
                Hi,
        
                Thanks for registering an account with us!
                                           
                Please click the following link to activate your account:
                $activation_link
                MESSAGE;

    $from = "From: register@meyer.ursse.org";

    mail($email, $subject, $message, $from);
}

function activate_user(int $user_id): bool {

    $query = 'UPDATE Users
              SET active = 1
              WHERE user_id = :user_id';

    $statement = dbConnect()->prepare($query);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}


function delete_user_by_id(int $user_id): bool {

    $query = 'DELETE FROM Users
              WHERE user_id = :user_id';

    $statement = dbConnect()->prepare($query);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}


function change_user_password(int $user_id, string $password) {

     $query = 'UPDATE Users
              SET password = :password
              WHERE user_id = :user_id';

    $statement = dbConnect()->prepare($query);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindValue(':password', $password, PDO::PARAM_STR);

    $statement->execute();
    // return false if no rows affected
    return ($statement->rowCount() <> 0);
}


function trim_input($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}


?>
