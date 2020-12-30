<?php
require "./vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger("PhpSandbox");
$log->pushHandler(new StreamHandler('var/log/app.log', Logger::WARNING));
$log->warning('Starting App');

try {
    $dbh = new PDO("mysql:host=" . getenv("MYSQL_HOST") . ";dbname=" . getenv("MYSQL_DBNAME") . "", getenv("MYSQL_USERNAME"), getenv("MYSQL_PASSWORD"));
    echo "Connected successfully<br>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$query = $dbh->prepare("CREATE TABLE IF NOT EXISTS person (id int, name varchar(255), age int)");
$query->execute();

$p1 = new Person("Artur", 10);

$query = $dbh->prepare("SELECT * FROM person");
$query->execute();
$results = $query->fetchAll();
var_dump($results);

if (!$results) {
    $query = $dbh->prepare("INSERT INTO person (name, age) VALUE (:name, :age)");
    $query->execute([
        ":name" => $p1->getName(),
        ":age" => $p1->getAge()
    ]);
}

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

/**
 * @param int $i
 * @return array
 */
function takesAnInt(int $i): array
{
    return [$i, "hello"];
}

$data = [1, "test2"];
$a = takesAnInt($data[0]);

var_dump($a);

$condition = rand(0, 5);
if ($condition) {
    var_dump($condition);
}
