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
$redis->hSet("redis:person", 'name', $p1->getName());
$redis->hSet("redis:person", 'age', $p1->getAge());
var_dump($redis->hGetAll("redis:person"));
var_dump($redis->hGet("redis:person", "name"));
var_dump($redis->info("memory"));
var_dump($redis->slowLog("GET"));

$memcached = new Memcached();
$memcached->addServer("memcached", 11211);
$memcached->set("memcached:person", $p1);
var_dump($memcached->get("memcached:person"));
var_dump($memcached->getStats());

$log->warning('Closing App');