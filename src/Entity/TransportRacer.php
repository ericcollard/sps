<?php

namespace App\Entity;

use App\Repository\TransportRacerRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TransportRacerRepository::class)]
#[UniqueEntity(
    fields: ['racer', 'transport'],
    message: 'La combinaison coureur / transport existe déjà.',
    errorPath: 'transport',
)]
class TransportRacer implements BlameableInterface
{
    use BlameableTrait;

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

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
