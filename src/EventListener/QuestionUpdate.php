<?php

namespace App\EventListener;

use App\Entity\Question;
use App\Entity\HistoricQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;


class QuestionUpdate
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function postUpdate(Question $question, LifecycleEventArgs $args): void
    {
            
            $question = $args->getObject();
            $title = $question->getTitle();
            $status = $question->getStatus();

            $historic = new HistoricQuestion();
            $historic->setTitle($title);
            $historic->setStatus($status);
            $historic->setCreatedAt(new \DateTimeImmutable());
            $this->em->persist($historic);
            $this->em->flush();
        
    }
    
}