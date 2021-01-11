<?php


class RedisExample implements SandboxExample
{

    public function run()
    {
        $redis = new Redis();
        $redis->connect("redis");
        $redisInfo = $redis->info();
        $redis->hSet("redis:person", 'name', $p1->getName());
        $redis->hSet("redis:person", 'age', $p1->getAge());
        var_dump($redis->hGetAll("redis:person"));
        var_dump($redis->hGet("redis:person", "name"));
        var_dump($redis->info("memory"));
        var_dump($redis->slowLog("GET"));
    }
}