<?php
try {
    $dbh = new PDO("mysql:host={$_ENV["MYSQL_HOST"]};dbname={$_ENV["MYSQL_DBNAME"]}", $_ENV["MYSQL_USERNAME"], $_ENV["MYSQL_PASSWORD"]);
    echo "Connected successfully<br>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

echo "Hello World!";