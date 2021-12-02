<?php

namespace App\Tests\Functional;

use App\ApiPlatform\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseListingResourcesTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request("POST", '/api/cheeses', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(401);

        $user = new User();
        $user->setEmail('admin@foo.pl');
        $user->setUsername("admin");
        $user->setPassword('$argon2id$v=19$m=65536,t=6,p=1$sErzgrcT/CTtvN/ZkMu4mw$e+WPH9Y1zA6ZwFN4woEI5SjGfuMFnd2+w4m428SY1v8');

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $client->request("POST", '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'admin@foo.pl',
                'password' => 'foo'
            ]
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}