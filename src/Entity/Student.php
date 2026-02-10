<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Responsible $responsible = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getResponsible(): ?Responsible
    {
        return $this->responsible;
    }

    public function setResponsible(?Responsible $responsible): static
    {
        $this->responsible = $responsible;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'responsible' => $this->getResponsible() ? [
                'id' => $this->getResponsible()->getId(),
                'name' => $this->getResponsible()->getName(),
            ] : null,
        ];
    }

}
