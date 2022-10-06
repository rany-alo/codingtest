<?php

namespace App\Tests;

use App\Entity\Answer;
use DateTimeImmutable;
use App\Entity\Question;
use DateTime;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;


class QuestionTest extends TestCase
{
    public function testIsTrue(): void
    {
        $question = new Question();
        $date = new DateTimeImmutable();

        $question->setTitle('title')
                 ->setPromoted(true)
                 ->setStatus('draft')
                 ->setCreatedAt($date)
                 ->setUpdatedAt($date);
        
        $this->assertTrue($question->getTitle() === 'title');
        $this->assertTrue($question->isPromoted() === true);
        $this->assertTrue($question->getStatus() === 'draft');
        $this->assertTrue($question->getCreatedAt() === $date);
        $this->assertTrue($question->getUpdatedAt() === $date);
    }

    public function testIsFalse(): void
    {
        $question = new Question();
        $answer = new Answer();
        $date = new DateTimeImmutable();

        $question->setTitle('title')
                 ->setPromoted(true)
                 ->setStatus('draft')
                 ->setCreatedAt($date)
                 ->setUpdatedAt($date);
        
        $this->assertFalse($question->getTitle() === 'title1');
        $this->assertFalse($question->isPromoted() === false);
        $this->assertFalse($question->getStatus() === 'published');
        $this->assertFalse($question->getCreatedAt() === new DateTime());
        $this->assertFalse($question->getUpdatedAt() === new DateTime());
    }

    public function testIsEmpty(): void
    {
        $question = new Question();
        
        $this->assertEmpty($question->getTitle());
        $this->assertEmpty($question->isPromoted());
        $this->assertEmpty($question->getStatus());
        $this->assertEmpty($question->getAnswers());
        $this->assertEmpty($question->getCreatedAt());
        $this->assertEmpty($question->getUpdatedAt());
    }

}
