<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

try {
    $dbh = new PDO("mysql:host=" . getenv("MYSQL_HOST") . ";dbname=" . getenv("MYSQL_DBNAME") . "", getenv("MYSQL_USERNAME"), getenv("MYSQL_PASSWORD"));
    echo "Connected successfully<br>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

echo "Hello World!<br>";

$log = new Logger("logger_name");
$log->pushHandler(new StreamHandler('app.log', Logger::WARNING));
$log->warning('Test warning');

$p1 = new Person("Artur", 30);