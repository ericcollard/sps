<?php

namespace App\Entity;

use App\Repository\EventRacerRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;

#[ORM\Entity(repositoryClass: EventRacerRepository::class)]
class EventRacer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $validated = null;

    #[ORM\Column(nullable: true)]
    private ?float $financeCorrection = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $financeCorrectionReason = null;

    #[ORM\ManyToOne(inversedBy: 'EventRacers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'EventRacers')]
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

    public function isValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): static
    {
        $this->validated = $validated;

        return $this;
    }

    public function getFinanceCorrection(): ?float
    {
        return $this->financeCorrection;
    }

    public function setFinanceCorrection(?float $financeCorrection): static
    {
        $this->financeCorrection = $financeCorrection;

        return $this;
    }

    public function getFinanceCorrectionReason(): ?string
    {
        return $this->financeCorrectionReason;
    }

    public function setFinanceCorrectionReason(?string $financeCorrectionReason): static
    {
        $this->financeCorrectionReason = $financeCorrectionReason;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

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
