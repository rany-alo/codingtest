<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\HistoricQuestionRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HistoricQuestionRepository::class)]
class HistoricQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list_questions'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['list_questions'])]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    #[Groups(['list_questions'])]
    private ?string $status = null;

    #[ORM\Column]
    #[Groups(['list_questions'])]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
