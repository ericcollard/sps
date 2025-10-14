<?php

namespace App\Entity;

use App\Repository\ParameterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterRepository::class)]
class Parameter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $StringValue = null;

    #[ORM\Column(nullable: true)]
    private ?float $NumericValue = null;

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

    public function getStringValue(): ?string
    {
        return $this->StringValue;
    }

    public function setStringValue(?string $StringValue): static
    {
        $this->StringValue = $StringValue;

        return $this;
    }

    public function getNumericValue(): ?float
    {
        return $this->NumericValue;
    }

    public function setNumericValue(?float $NumericValue): static
    {
        $this->NumericValue = $NumericValue;

        return $this;
    }
}
