<?php

namespace App\Tests\Functional;

use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CheeseListingResourcesTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    /**
     * @throws TransportExceptionInterface
     */
    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request("POST", '/api/cheeses', [
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogIn($client, "admin@foo.pl", "foo");

        $client->request("POST", '/api/cheeses', [
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(400);
    }
}