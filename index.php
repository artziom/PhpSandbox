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

$log = new Logger("PhpSandbox");
$log->pushHandler(new StreamHandler('var/log/app.log', Logger::WARNING));
$log->warning('Starting App');

$p1 = new Person("Artur", 10);

$redis = new Redis();
$redis->connect("redis");
$redisInfo = $redis->info();
$redis->set("server:name", "PhpSandbox");
echo $redis->get("server:name");

echo "<br>";

$memcached = new Memcached();
$memcached->addServer("memcached", 11211);
$memcached->set("test", "Hello World!");
echo $memcached->get("test");

$log->warning('Closing App');