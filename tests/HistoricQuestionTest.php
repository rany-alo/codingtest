<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\HistoricQuestion;
use DateTime;
use DateTimeImmutable;

class HistoricQuestionTest extends TestCase
{
    public function testIsTrue(): void
    {
        $historicQuestion = new HistoricQuestion();
        $date = new DateTimeImmutable();

        $historicQuestion->setTitle('title')
                 ->setStatus('draft')
                 ->setCreatedAt($date);
        
        $this->assertTrue($historicQuestion->getTitle() === 'title');
        $this->assertTrue($historicQuestion->getStatus() === 'draft');
        $this->assertTrue($historicQuestion->getCreatedAt() === $date);

    }

    public function testIsFalse(): void
    {
        $historicQuestion = new HistoricQuestion();
        $date = new DateTimeImmutable();

        $historicQuestion->setTitle('title')
                 ->setStatus('draft')
                 ->setCreatedAt($date);
        
        $this->assertFalse($historicQuestion->getTitle() === 'false');
        $this->assertFalse($historicQuestion->getStatus() === 'pubished');
        $this->assertFalse($historicQuestion->getCreatedAt() === new DateTime());
    }

    public function testIsEmpty(): void
    {
        $historicQuestion = new HistoricQuestion();
        
        $this->assertEmpty($historicQuestion->getTitle());
        $this->assertEmpty($historicQuestion->getStatus());
        $this->assertEmpty($historicQuestion->getCreatedAt());
    }
}
