<?php
namespace App\Example;

use App\Utils\Person;
use Redis;

class RedisExample implements SandboxExample
{

    public function run()
    {
        $p1 = new Person("Artur", 32);

        $redis = new Redis();
        $redis->connect("redis");
        $redisInfo = $redis->info();
        $redis->hSet("redis:person", 'name', $p1->getName());
        $redis->hSet("redis:person", 'age', $p1->getAge());
        var_dump($redisInfo);
        var_dump($redis->hGetAll("redis:person"));
        var_dump($redis->hGet("redis:person", "name"));
        var_dump($redis->info("memory"));
        var_dump($redis->slowLog("GET"));
    }
}