<?php
namespace App\Example;

use App\Utils\Person;
use Memcached;

class MemcachedExample implements SandboxExample
{
    public function run()
    {
        $p1 = new Person("Artur", 32);

        $memcached = new Memcached();
        $memcached->addServer("memcached", 11211);
        $memcached->set("memcached:person", $p1);
        var_dump($memcached->get("memcached:person"));
        var_dump($memcached->getStats());
    }
}