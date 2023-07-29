<?php
function dbConnect() {
    // retrieve database info from env file
    $secretFile = fopen("env.txt", "r");

    if ($secretFile == false) {
        echo ("Error in opening database information file");
        exit();
    }

    $servername = trim(fgets($secretFile));
    $username = trim(fgets($secretFile));
    $password = trim(fgets($secretFile));
    $database = trim(fgets($secretFile));

    fclose($secretFile);

    // begin server connection
    try {
        $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
        return $connection;
    } catch (PDOException $e) {
        echo "Error! Stack trace: " . $e->getMessage();
        return false;
    }
}
?>
