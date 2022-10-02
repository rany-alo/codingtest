<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnswerRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;



#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list_questions'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['list_questions'])]
    private ?string $channel = null;

    #[ORM\Column(length: 500)]
    #[Groups(['list_questions'])]
    private ?string $body = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('channel', new NotBlank([
            'message' => 'Le channel est obligatoire'
        ]));
        $metadata->addPropertyConstraint('body', new NotBlank([
            'message' => 'Le body est obligatoire'
        ]));
        $metadata->addPropertyConstraint('channel', new Assert\Choice([
            'choices' => ['faq', 'bot'],
            'message' => 'Le channel doit être [faq ou bot].',
        ]));
    }
}
