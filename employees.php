<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Employees</title>
<link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<h1>Employees</h1>
<p>
	Return to
	<a href="index.html">
	   Home
	</a>
</p>

<p>Quick shoutout to
	 <a href="https://www.w3schools.com/php/php_mysql_select.asp">this tutorial</a>
	  from w3schools.com for providing a code demo to base this database fetch on!
</p>

<?php

// connection and table construction code scooped from w3schools.com
// https://www.w3schools.com/php/php_mysql_select.asp

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Lastname</th><th>Firstname</th><th>Position</th></tr>";

class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
      parent::__construct($it, self::LEAVES_ONLY);
        }

  function current() {
      return "<td class='employee-data'>" . parent::current(). "</td>";
        }

  function beginChildren() {
      echo "<tr>";
        }

  function endChildren() {
      echo "</tr>" . "\n";
        }
}

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

    $query = "SELECT * FROM Employees LIMIT 100"; // LIMIT in case we upscale... :P

    $prepared_query = $connection->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $prepared_query->execute();

    $result = $prepared_query->setFetchMode(PDO::FETCH_ASSOC);

    // I wish I knew what was going on here... thanks internet!
    foreach(new TableRows(new RecursiveArrayIterator($prepared_query->fetchAll())) as $k=>$v) {
    	echo $v;
    }

} catch (PDOException $e) {
    echo "Error! Stack trace: " . $e->getMessage();
}


$connection = null;
echo "</table>";
?>

</body>
</html>
