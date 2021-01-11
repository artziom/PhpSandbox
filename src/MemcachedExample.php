<?php


class MemcachedExample implements SandboxExample
{

    public function run()
    {
        $memcached = new Memcached();
        $memcached->addServer("memcached", 11211);
        $memcached->set("memcached:person", $p1);
        var_dump($memcached->get("memcached:person"));
        var_dump($memcached->getStats());
    }
}