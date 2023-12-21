<?php

session_start();

// verify user is logged in
if (!isset($_SESSION['username']))
{
    header("Location: index.php");
    exit();
}

// include 'authenticate.php';
include 'menu.php';

// verify user has admin privileges
$user = find_user_by_username($_SESSION['username']);

if (!$user || !(is_user_admin($user))) {
     header("Location: index.php");
    exit();
}

// user verified to be admin

//////////////////////////////


$query = "SELECT * FROM Users";

$statement = dbConnect()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
$statement->execute();

$result = $statement->setFetchMode(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta charset="utf-8">
        <title>Admin</title>
        <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="container">
            <h1>Admin</h1>
            <h4>Users</h4>
            <a href="/api-test.php">API Test</a>
            <p class="error">
                <?php if (isset($_POST['message'])){
                   echo $_POST['message'];
                } ?>
            </p>
            <table style='border: solid 1px black;'>
                <tr><th></th><th>user_id</th><th>email</th><th>username</th><th>password</th><th>active</th><th>admin</th><th>activation_code</th></tr>

                <?php
                /*
                // get number of lines in DB
                $count_query = "SELECT COUNT(user_id) FROM Users";
                $statement = dbConnect()->prepare($count_query);

                $statement->execute();
                $count = $statement->fetch(PDO::FETCH_BOTH);
                $row_count = $count[0];
                print_r($count);
                */

                $query = "SELECT * FROM Users";
                $statement = dbConnect()->prepare($query);

                $statement->execute();

                $results = $statement->fetchAll(PDO::FETCH_BOTH);

                // wrap each row in a form with an id = to the user_id.
                // Then we dyamically allocate options to interact with
                // each field in the table
                //
                // There are 2 ways of interacting:
                // 1. Change password
                // 2. Delete user


                // $row_count = 0;
                foreach ($results as $row) {
                    echo "<form action='delete-user.php' method='post'>";
                    echo "<tr>";
                    // include rows for control options
                    echo "<td>
                            <input type='hidden' name='user_id' value=" . $row['user_id'] . ">
                            <input class='button-primary' type='submit' value='Delete'></td>";
                    for ($column = 0; $column < count($row) / 2; $column++) {
                        echo "<td class='admin-data'>" . $row[$column] . "</td>";
                    }
                    echo "</tr></form> \n";
                    // $row_count++;
                    // print_r($row);
                }
                ?>
            </table>

            <h4>Change Password</h4>
            <p>To change a user's password, enter the user_id and the new password below:</p>
            <form action='change-password.php' method='post'>
                <label for="user_id">User ID:</label>
                    <input type="text" name="user_id"><br>
                    <label for="name">New Password:</label>
                        <input type="text" name="password"><br><br>
                <input class="button-primary" type="submit" value="Change Password">
            </form>


       </div>
    </body>
</html>
