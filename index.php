<?php
$servername = "localhost";
$username = "root";
$password = "secret";
$dbname = "test";

try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    echo "Connected successfully<br>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

echo "Hello World!";