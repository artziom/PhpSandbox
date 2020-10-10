<?php


use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testIsAdult()
    {
        $person = new Person("Artur", 30);
        $this->assertTrue($person->isAdult(), "This person should be adult");
    }
}
