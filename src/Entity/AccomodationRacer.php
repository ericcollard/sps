<?php

namespace App\Entity;

use App\Repository\AccomodationRacerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccomodationRacerRepository::class)]
class AccomodationRacer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $racerPlace = null;

    #[ORM\Column]
    private ?int $nonracerPlaceCount = null;

    #[ORM\ManyToOne(inversedBy: 'accomodationRacers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Accomodation $accomodation = null;

    #[ORM\ManyToOne(inversedBy: 'accomodationsRacers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Racer $racer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isRacerPlace(): ?bool
    {
        return $this->racerPlace;
    }

    public function setRacerPlace(bool $racerPlace): static
    {
        $this->racerPlace = $racerPlace;

        return $this;
    }

    public function getNonracerPlaceCount(): ?int
    {
        return $this->nonracerPlaceCount;
    }

    public function setNonracerPlaceCount(int $nonracerPlaceCount): static
    {
        $this->nonracerPlaceCount = $nonracerPlaceCount;

        return $this;
    }

    public function getAccomodation(): ?Accomodation
    {
        return $this->accomodation;
    }

    public function setAccomodation(?Accomodation $accomodation): static
    {
        $this->accomodation = $accomodation;

        return $this;
    }

    public function getRacer(): ?Racer
    {
        return $this->racer;
    }

    public function setRacer(?Racer $racer): static
    {
        $this->racer = $racer;

        return $this;
    }
}
