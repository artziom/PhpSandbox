<?php

namespace App\Tests\Functional;

use App\Entity\CheeseListing;
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

        $authenticatedUser = $this->createUserAndLogIn($client, "user@foo.pl", "foo");
        $otherUser = $this->createUser("otheruser@example.com", "foo");

        $cheesyData = [
            'title' => "Serek",
            'description' => 'Super serek',
            'price' => 5000
        ];

        $client->request("POST", '/api/cheeses', [
            'json' => $cheesyData
        ]);

        $this->assertResponseStatusCodeSame(201);


        $client->request('POST', '/api/cheeses', [
            'json' => $cheesyData + ['owner' => '/api/users/'.$otherUser->getId()]
        ]);

        $this->assertResponseStatusCodeSame(400, 'not passing the correct owner');

        $client->request('POST', '/api/cheeses', [
            'json' => $cheesyData + ['owner' => '/api/users/'.$authenticatedUser->getId()]
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdateCheeseListing(){
        $client = self::createClient();
        $user1 = $this->createUser("user1@foo.pl", 'foo');
        $user2 = $this->createUser("user2@foo.pl", 'foo');

        $cheeseListing = new CheeseListing("Block of cheddar");
        $cheeseListing->setOwner($user1);

        $cheeseListing->setPrice(10);
        $cheeseListing->setDescription("mmm");

        $em = $this->getEntityManager();
        $em->persist($cheeseListing);
        $em->flush();

        $this->logIn($client, "user2@foo.pl", "foo");
        $client->request("PUT", "/api/cheeses/".$cheeseListing->getId(),[
            'json' => ['title' => 'updated', 'owner' => '/api/users/'.$user2->getId()]
        ]);

        $this->assertResponseStatusCodeSame(403);

        $this->logIn($client, "user1@foo.pl", "foo");
        $client->request("PUT", "/api/cheeses/".$cheeseListing->getId(),[
            'json' => ['title' => 'updated']
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetCheeseListingCollection(){
        $client = self::createClient();
        $user = $this->createUser('testsera@com.pl', 'foo');

        $cheeseListing1 = new CheeseListing('cheese1');
        $cheeseListing1->setOwner($user);
        $cheeseListing1->setPrice(1000);
        $cheeseListing1->setDescription('sere');

        $cheeseListing2 = new CheeseListing('cheese2');
        $cheeseListing2->setOwner($user);
        $cheeseListing2->setPrice(2000);
        $cheeseListing2->setDescription('Drugi serek');
        $cheeseListing2->setIsPublished(true);

        $cheeseListing3 = new CheeseListing('cheese3');
        $cheeseListing3->setOwner($user);
        $cheeseListing3->setPrice(3000);
        $cheeseListing3->setDescription('Trzeci serek');
        $cheeseListing3->setIsPublished(true);

        $em = $this->getEntityManager();
        $em->persist($cheeseListing1);
        $em->persist($cheeseListing2);
        $em->persist($cheeseListing3);
        $em->flush();

        $client->request('GET', '/api/cheeses');
        $this->assertJsonContains(['hydra:totalItems' => 2]);
    }
}