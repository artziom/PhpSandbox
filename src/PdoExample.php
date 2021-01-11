<?php


class PdoExample implements SandboxExample
{

    public function run()
    {
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
    }
}