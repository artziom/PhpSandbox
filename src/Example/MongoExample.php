<?php
namespace App\Example;

use MongoDB\Client;

class MongoExample implements SandboxExample
{

    public function run()
    {
        $mongoClient = new Client("mongodb://mongo/", [
            'username' => 'root',
            'password' => 'secret',
        ]);

        $mongoDB = $mongoClient->selectDatabase("php_sandbox");

        $userCollection = $mongoDB->selectCollection("movies");
        $userCollection->drop();

        $userCollection->insertOne([
            'title' => "Godzilla",
            "year" => 2014
        ]);

        $userCollection->insertOne([
            'title' => "Godzilla King of the Monsters",
            "year" => 2018
        ]);

        $userCollection->updateMany([
            'year' => 2018
        ], [
            '$set' => ["year" => 2019]
        ]);

        $allMovies = $userCollection->find();
        foreach ($allMovies as $movie) {
            var_dump($movie);
        }
    }
}