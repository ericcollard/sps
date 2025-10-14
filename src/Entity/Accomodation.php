<?php

namespace App\Entity;

use App\Repository\AccomodationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;

#[ORM\Entity(repositoryClass: AccomodationRepository::class)]
class Accomodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dayDate = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    /**
     * @var Collection<int, AccomodationRacer>
     */
    #[ORM\OneToMany(targetEntity: AccomodationRacer::class, mappedBy: 'accomodation', orphanRemoval: true)]
    private Collection $accomodationRacers;

    #[ORM\ManyToOne(inversedBy: 'accomodations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->accomodationRacers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getDayDate()->format("d/m/Y").' à '.$this->getLocation();  // or some string field in your Vegetal Entity
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayDate(): ?\DateTime
    {
        return $this->dayDate;
    }

    public function setDayDate(\DateTime $dayDate): static
    {
        $this->dayDate = $dayDate;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, AccomodationRacer>
     */
    public function getAccomodationRacers(): Collection
    {
        return $this->accomodationRacers;
    }

    public function addAccomodationRacer(AccomodationRacer $accomodationRacer): static
    {
        if (!$this->accomodationRacers->contains($accomodationRacer)) {
            $this->accomodationRacers->add($accomodationRacer);
            $accomodationRacer->setAccomodation($this);
        }

        return $this;
    }

    public function removeAccomodationRacer(AccomodationRacer $accomodationRacer): static
    {
        if ($this->accomodationRacers->removeElement($accomodationRacer)) {
            // set the owning side to null (unless already changed)
            if ($accomodationRacer->getAccomodation() === $this) {
                $accomodationRacer->setAccomodation(null);
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
        $countJuniorGirl = 0;
        $countJuniorBoy = 0;
        foreach ($this->getAccomodationRacers() as $accomodationRacer)
        {
            $NbCnt = 0;
            $racer = $accomodationRacer->getRacer();
            if ($accomodationRacer->isRacerPlace()) $NbCnt  = 1;
            if ($NbCnt > 0)
            {
                if ($racer->isSkiInstructor() or $racer->isSkiCoach())
                {
                    $countCoach+=$NbCnt;
                }
                elseif ($racer->getSex() == "Fille")
                {
                    $countJuniorGirl+=$NbCnt;
                }
                else
                {
                    $countJuniorBoy+=$NbCnt;
                }
            }
            if ($accomodationRacer->getNonracerPlaceCount() > 0) $countAccompagnant +=$accomodationRacer->getNonracerPlaceCount();
        }

        switch ($cible)
        {
            case 'Girl':
                return $countJuniorGirl;
            case 'Boy':
                return $countJuniorBoy;
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
