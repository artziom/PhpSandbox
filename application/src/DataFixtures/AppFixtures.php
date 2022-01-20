<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        QuestionFactory::createMany(20);

        QuestionFactory::new()
            ->unpublished()
            ->many(5)
            ->create()
        ;

        $answer = new Answer();
        $answer->setContent('Great question! I don\'t know.');
        $answer->setUsername('artziom');

        $question = new Question();
        $question->setName('How to un-disappear your wallet?');
        $question->setQuestion('... Hi every one....');
        $question->addAnswer($answer);

        $manager->persist($answer);
        $manager->persist($question);

        $manager->flush();
    }
}
