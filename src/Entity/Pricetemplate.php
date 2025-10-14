<?php

namespace App\Entity;

use App\Repository\PricetemplateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PricetemplateRepository::class)]
class Pricetemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $skiday = null;

    #[ORM\Column]
    private ?int $accomodation = null;

    #[ORM\Column]
    private ?int $skipass = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSkiday(): ?int
    {
        return $this->skiday;
    }

    public function setSkiday(int $skiday): static
    {
        $this->skiday = $skiday;

        return $this;
    }

    public function getAccomodation(): ?int
    {
        return $this->accomodation;
    }

    public function setAccomodation(int $accomodation): static
    {
        $this->accomodation = $accomodation;

        return $this;
    }

    public function getSkipass(): ?int
    {
        return $this->skipass;
    }

    public function setSkipass(int $skipass): static
    {
        $this->skipass = $skipass;

        return $this;
    }
}
