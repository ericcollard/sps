<?php

namespace App\Entity;

use App\Repository\TransportRacerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRacerRepository::class)]
class TransportRacer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $racerPlace = null;

    #[ORM\Column]
    private ?int $nonracerPlaceCount = null;

    #[ORM\Column]
    private ?int $availablePlaceCount = null;

    #[ORM\ManyToOne(inversedBy: 'transportRacers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Transport $transport = null;

    #[ORM\ManyToOne(inversedBy: 'transportRacers')]
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

    public function getAvailablePlaceCount(): ?int
    {
        return $this->availablePlaceCount;
    }

    public function setAvailablePlaceCount(int $availablePlaceCount): static
    {
        $this->availablePlaceCount = $availablePlaceCount;

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): static
    {
        $this->transport = $transport;

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
