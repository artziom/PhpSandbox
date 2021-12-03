<?php

namespace App\Test;

use App\ApiPlatform\Test\ApiTestCase;
use App\ApiPlatform\Test\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CustomApiTestCase extends ApiTestCase
{
    protected function createUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername(substr($email, 0, strpos($email, '@')));

        $encoded = self::$container->get(UserPasswordEncoderInterface::class)->encodePassword($user, $password);
        $user->setPassword($encoded);

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }


    /**
     * @throws TransportExceptionInterface
     */
    protected function logIn(Client $client, string $email, string $password){
        $client->request("POST", '/login', [
            'json' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        $this->assertResponseStatusCodeSame(204);
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function createUserAndLogIn(Client $client, string $email, string $password): User
    {
        $user = $this->createUser($email, $password);
        $this->logIn($client, $email, $password);

        return $user;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$container->get('doctrine')->getManager();
    }
}