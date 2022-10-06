<?php

namespace App\Tests;

use App\Entity\Answer;
use App\Entity\Question;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    public function testIsTrue(): void
    {
        $answer = new Answer();
        $question = new Question;

        $answer->setChannel('faq')
               ->setBody('body')
               ->setQuestion($question);
        
        $this->assertTrue($answer->getChannel() === 'faq');
        $this->assertTrue($answer->getBody() === 'body');
        $this->assertTrue($answer->getQuestion() === $question);
    }

    public function testIsFalse(): void
    {
        $answer = new Answer();
        $question = new Question;

        $answer->setChannel('faq')
               ->setBody('body')
               ->setQuestion($question);
        
        $this->assertFalse($answer->getChannel() === 'bot');
        $this->assertFalse($answer->getBody() === 'false');
        $this->assertFalse($answer->getQuestion() === 'false');
    }

    public function testIsEmpty(): void
    {
        $answer = new Answer();
        
        $this->assertEmpty($answer->getChannel());
        $this->assertEmpty($answer->getbody());
        $this->assertEmpty($answer->getQuestion());
    }
}
