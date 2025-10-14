<?php

namespace App\Entity;

use App\Repository\SkidayRacerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkidayRacerRepository::class)]
class SkidayRacer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $trainingRacer = null;

    #[ORM\Column]
    private ?bool $skipassRacer = null;

    #[ORM\Column]
    private ?int $skipassNonracerCount = null;

    #[ORM\Column]
    private ?bool $lunchRacer = null;

    #[ORM\ManyToOne(inversedBy: 'SkidayRacers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Racer $racer = null;

    #[ORM\ManyToOne(inversedBy: 'SkidayRacers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skiday $skiday = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isTrainingRacer(): ?bool
    {
        return $this->trainingRacer;
    }

    public function setTrainingRacer(bool $trainingRacer): static
    {
        $this->trainingRacer = $trainingRacer;

        return $this;
    }

    public function isSkipassRacer(): ?bool
    {
        return $this->skipassRacer;
    }

    public function setSkipassRacer(bool $skipassRacer): static
    {
        $this->skipassRacer = $skipassRacer;

        return $this;
    }

    public function getSkipassNonracerCount(): ?int
    {
        return $this->skipassNonracerCount;
    }

    public function setSkipassNonracerCount(int $skipassNonracerCount): static
    {
        $this->skipassNonracerCount = $skipassNonracerCount;

        return $this;
    }

    public function isLunchRacer(): ?bool
    {
        return $this->lunchRacer;
    }

    public function setLunchRacer(bool $lunchRacer): static
    {
        $this->lunchRacer = $lunchRacer;

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

    public function getSkiday(): ?Skiday
    {
        return $this->skiday;
    }

    public function setSkiday(?Skiday $skiday): static
    {
        $this->skiday = $skiday;

        return $this;
    }
}
