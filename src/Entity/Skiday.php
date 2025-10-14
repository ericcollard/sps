<?php

namespace App\Entity;

use App\Repository\SkidayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkidayRepository::class)]
class Skiday
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dayDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    private ?string $dayType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $memo = null;

    #[ORM\Column(nullable: true)]
    private ?float $priceYouth = null;

    #[ORM\Column(nullable: true)]
    private ?int $priceYouthLimit = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?float $lunchPrice = null;

    #[ORM\ManyToOne(inversedBy: 'Skidays')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    /**
     * @var Collection<int, SkidayRacer>
     */
    #[ORM\OneToMany(targetEntity: SkidayRacer::class, mappedBy: 'skiday', orphanRemoval: true)]
    private Collection $SkidayRacers;

    public function __construct()
    {
        $this->SkidayRacers = new ArrayCollection();
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

    public function getDayType(): ?string
    {
        return $this->dayType;
    }

    public function setDayType(string $dayType): static
    {
        $this->dayType = $dayType;

        return $this;
    }

    public function getMemo(): ?string
    {
        return $this->memo;
    }

    public function setMemo(?string $memo): static
    {
        $this->memo = $memo;

        return $this;
    }

    public function getPriceYouth(): ?float
    {
        return $this->priceYouth;
    }

    public function setPriceYouth(float $priceYouth): static
    {
        $this->priceYouth = $priceYouth;

        return $this;
    }

    public function getPriceYouthLimit(): ?int
    {
        return $this->priceYouthLimit;
    }

    public function setPriceYouthLimit(?int $priceYouthLimit): static
    {
        $this->priceYouthLimit = $priceYouthLimit;

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

    public function getLunchPrice(): ?float
    {
        return $this->lunchPrice;
    }

    public function setLunchPrice(?float $lunchPrice): static
    {
        $this->lunchPrice = $lunchPrice;

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

    /**
     * @return Collection<int, SkidayRacer>
     */
    public function getSkidayRacers(): Collection
    {
        return $this->SkidayRacers;
    }

    public function addSkidayRacer(SkidayRacer $skidayRacer): static
    {
        if (!$this->SkidayRacers->contains($skidayRacer)) {
            $this->SkidayRacers->add($skidayRacer);
            $skidayRacer->setSkiday($this);
        }

        return $this;
    }

    public function removeSkidayRacer(SkidayRacer $skidayRacer): static
    {
        if ($this->SkidayRacers->removeElement($skidayRacer)) {
            // set the owning side to null (unless already changed)
            if ($skidayRacer->getSkiday() === $this) {
                $skidayRacer->setSkiday(null);
            }
        }

        return $this;
    }

    public function getSkipassCount(string $cible): int
    {
        $countAdulte = 0;
        $countJunior = 0;
        $countAccompagnant = 0;
        $skydayDate = $this->getDayDate();
        foreach ($this->getSkidayRacers() as $skidayRacer)
        {
            $NbPass = 0;
            $racer = $skidayRacer->getRacer();
            if ($skidayRacer->isSkipassRacer()) $NbPass  = 1;
            if ($NbPass > 0)
            {
                if ($this->getPriceYouthLimit() > 0 and $racer->getAgeAtDay($skydayDate) <= $this->getPriceYouthLimit())
                {
                    // Junior
                    $countJunior+=$NbPass;
                }
                else
                {
                    // adulte
                    $countAdulte+=$NbPass;
                }
            }
            if ($skidayRacer->getSkipassNonracerCount() > 0) $countAccompagnant +=$skidayRacer->getSkipassNonracerCount();
        }

        switch ($cible)
        {
            case 'Junior':
                return $countJunior;
            case 'Accompagnant':
                return $countAccompagnant;
            default:
                return $countAdulte;
        }
    }

    public function getTrainingCount(string $cible): int
    {
        $countRacer = 0;
        $countCoach = 0;
        $countMoniteur = 0;
        foreach ($this->getSkidayRacers() as $skidayRacer)
        {
            $NbCnt = 0;
            $racer = $skidayRacer->getRacer();
            if ($skidayRacer->isTrainingRacer()) $NbCnt  = 1;
            if ($NbCnt > 0)
            {
                if ($racer->isSkiCoach() )
                {
                    // Junior
                    $countCoach+=$NbCnt;
                }
                elseif ($racer->isSkiInstructor())
                {
                    // adulte
                    $countMoniteur+=$NbCnt;
                }
                else
                {
                    $countRacer+=$NbCnt;
                }
            }
        }

        switch ($cible)
        {
            case 'Racer':
                return $countRacer;
            case 'Coach':
                return $countCoach;
            default:
                return $countMoniteur;
        }
    }

    public function getDinnerCount(string $cible): int
    {
        $countRacer = 0;
        $countCoach = 0;
        foreach ($this->getSkidayRacers() as $skidayRacer)
        {
            $NbCnt = 0;
            $racer = $skidayRacer->getRacer();
            if ($skidayRacer->isLunchRacer()) $NbCnt  = 1;
            if ($NbCnt > 0)
            {
                if ($racer->isSkiCoach() or $racer->isSkiInstructor())
                {
                    $countCoach+=$NbCnt;
                }
                else
                {
                    $countRacer+=$NbCnt;
                }
            }
        }

        switch ($cible)
        {
            case 'Racer':
                return $countRacer;
            default:
                return $countCoach;
        }
    }

}
