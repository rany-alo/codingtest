<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use DateTimeImmutable;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++){
            $question = new Question();
            $answer = new Answer();
            $datetime = new DateTimeImmutable();

            $question->setTitle($faker->sentence($nbWords = 4, $variableNbWords = true));
            $question->setPromoted($faker->boolean($chanceOfGettingTrue = 50));
            $question->setStatus($faker->randomElement($array = array ('draft','published')));
                
            $answer->setChannel($faker->randomElement($array = array ('faq','bot')));
            $answer->setBody($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
            $answer->setQuestion($question);
            
            $question->addAnswer($answer);
            $question->setCreatedAt($datetime);
            $question->setUpdatedAt($datetime);


            $manager->persist($question);
            $manager->persist($answer);
        }



        $manager->flush();
    }
}
