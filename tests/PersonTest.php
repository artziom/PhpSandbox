<?php


use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testIsAdult()
    {
        $person = new Person("Artur", 30);
        $this->assertTrue($person->isAdult(), "This person should be adult");

        $person = new Person("Artur", 18);
        $this->assertTrue($person->isAdult(), "This person should be adult");
    }

    public function testIsKid()
    {
        $person = new Person("Artur", 12);
        $this->assertFalse($person->isAdult(), "This person should be kid");
    }
}
