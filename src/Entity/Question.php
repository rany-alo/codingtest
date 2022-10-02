<?php

namespace App\Entity;

use Assert\Blank;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list_questions'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['list_questions'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['list_questions'])]
    private ?bool $promoted = null;

    #[ORM\Column(length: 100)]
    #[Groups(['list_questions'])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class)]
    #[Groups(['list_questions'])]
    private Collection $answers;

    #[ORM\Column]
    #[Groups(['list_questions'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Groups(['list_questions'])]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

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

    public function isPromoted(): ?bool
    {
        return $this->promoted;
    }

    public function setPromoted(bool $promoted): self
    {
        $this->promoted = $promoted;

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

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new NotBlank([
            'message' => 'Le title est obligatoire'
        ]));
        $metadata->addPropertyConstraint('promoted', new NotBlank([
            'message' => 'Le promoted est obligatoire'
        ]));
        $metadata->addPropertyConstraint('status', new NotBlank([
            'message' => 'Le status est obligatoire'
        ]));
        $metadata->addPropertyConstraint('status', new Assert\Choice([
            'choices' => ['draft', 'published'],
            'message' => 'Le status doit être [draft ou published].',
        ]));
        $metadata->addPropertyConstraint('promoted', new Assert\Choice([
            'choices' => [true, false],
            'message' => 'Le promoted doit être [true ou false].',
        ]));
    }
}
