<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport implements BlameableInterface
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $direction = null;

    /**
     * @var Collection<int, TransportRacer>
     */
    #[ORM\OneToMany(targetEntity: TransportRacer::class, mappedBy: 'transport', orphanRemoval: true)]
    private Collection $transportRacers;

    #[ORM\ManyToOne(inversedBy: 'transports')]
    private ?Event $event = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->transportRacers = new ArrayCollection();
    }


    public function __toString(): string
    {
        return $this->getEvent()->getTitle().' - '.$this->getDirection() ;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return Collection<int, TransportRacer>
     */
    public function getTransportRacers(): Collection
    {
        return $this->transportRacers;
    }

    public function addTransportRacer(TransportRacer $transportRacer): static
    {
        if (!$this->transportRacers->contains($transportRacer)) {
            $this->transportRacers->add($transportRacer);
            $transportRacer->setTransport($this);
        }

        return $this;
    }

    public function removeTransportRacer(TransportRacer $transportRacer): static
    {
        if ($this->transportRacers->removeElement($transportRacer)) {
            // set the owning side to null (unless already changed)
            if ($transportRacer->getTransport() === $this) {
                $transportRacer->setTransport(null);
            }
        }

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



    public function getCount(string $cible): int
    {
        $countCoach = 0;
        $countAccompagnant = 0;
        $countRacer = 0;
        foreach ($this->getTransportRacers() as $transportRacer)
        {
            $NbCnt = 0;
            $racer = $transportRacer->getRacer();
            if ($transportRacer->isRacerPlace()) $NbCnt  = 1;
            if ($NbCnt > 0)
            {
                if ($racer->isSkiInstructor() or $racer->isSkiCoach())
                {
                    $countCoach+=$NbCnt;
                }
                else
                {
                    $countRacer+=$NbCnt;
                }
            }
            if ($transportRacer->getNonracerPlaceCount() > 0) $countAccompagnant +=$transportRacer->getNonracerPlaceCount();
        }

        switch ($cible)
        {
            case 'Racer':
                return $countRacer;
            case 'Coach':
                return $countCoach;
            default:
                return $countAccompagnant;
        }
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
