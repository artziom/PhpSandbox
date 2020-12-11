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

$log = new Logger("logger_name");
$log->pushHandler(new StreamHandler('app.log', Logger::WARNING));

$p1 = new Person("Artur", 10);
if (!$p1->isAdult()) {
    $log->warning('This person should be an adult!');
}