<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event implements BlameableInterface
{
    use BlameableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $startdate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $enddate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $memo = null;

    /**
     * @var Collection<int, EventRacer>
     */
    #[ORM\OneToMany(targetEntity: EventRacer::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $EventRacers;

    /**
     * @var Collection<int, Skiday>
     */
    #[ORM\OneToMany(targetEntity: Skiday::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $Skidays;

    /**
     * @var Collection<int, Accomodation>
     */
    #[ORM\OneToMany(targetEntity: Accomodation::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $accomodations;

    /**
     * @var Collection<int, Transport>
     */
    #[ORM\OneToMany(targetEntity: Transport::class, mappedBy: 'event')]
    private Collection $transports;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Accounting>
     */
    #[ORM\OneToMany(targetEntity: Accounting::class, mappedBy: 'event')]
    private Collection $accountings;


    public function __construct()
    {
        $this->EventRacers = new ArrayCollection();
        $this->Skidays = new ArrayCollection();
        $this->accomodations = new ArrayCollection();
        $this->transports = new ArrayCollection();
        $this->accountings = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getTitle();  // or some string field in your Vegetal Entity
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartdate(): ?\DateTime
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTime $startdate): static
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTime
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTime $enddate): static
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, EventRacer>
     */
    public function getEventRacers(): Collection
    {
        return $this->EventRacers;
    }

    public function addEventRacer(EventRacer $eventRacer): static
    {
        if (!$this->EventRacers->contains($eventRacer)) {
            $this->EventRacers->add($eventRacer);
            $eventRacer->setEvent($this);
        }

        return $this;
    }

    public function removeEventRacer(EventRacer $eventRacer): static
    {
        if ($this->EventRacers->removeElement($eventRacer)) {
            // set the owning side to null (unless already changed)
            if ($eventRacer->getEvent() === $this) {
                $eventRacer->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skiday>
     */
    public function getSkidays(): Collection
    {
        return $this->Skidays;
    }

    public function addSkiday(Skiday $skiday): static
    {
        if (!$this->Skidays->contains($skiday)) {
            $this->Skidays->add($skiday);
            $skiday->setEvent($this);
        }

        return $this;
    }

    public function removeSkiday(Skiday $skiday): static
    {
        if ($this->Skidays->removeElement($skiday)) {
            // set the owning side to null (unless already changed)
            if ($skiday->getEvent() === $this) {
                $skiday->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Accomodation>
     */
    public function getAccomodations(): Collection
    {
        return $this->accomodations;
    }

    public function addAccomodation(Accomodation $accomodation): static
    {
        if (!$this->accomodations->contains($accomodation)) {
            $this->accomodations->add($accomodation);
            $accomodation->setEvent($this);
        }

        return $this;
    }

    public function removeAccomodation(Accomodation $accomodation): static
    {
        if ($this->accomodations->removeElement($accomodation)) {
            // set the owning side to null (unless already changed)
            if ($accomodation->getEvent() === $this) {
                $accomodation->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransports(): Collection
    {
        return $this->transports;
    }

    public function addTransport(Transport $transport): static
    {
        if (!$this->transports->contains($transport)) {
            $this->transports->add($transport);
            $transport->setEvent($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): static
    {
        if ($this->transports->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getEvent() === $this) {
                $transport->setEvent(null);
            }
        }

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

    /**
     * @return Collection<int, Accounting>
     */
    public function getAccountings(): Collection
    {
        return $this->accountings;
    }

    public function addAccounting(Accounting $accounting): static
    {
        if (!$this->accountings->contains($accounting)) {
            $this->accountings->add($accounting);
            $accounting->setEvent($this);
        }

        return $this;
    }

    public function removeAccounting(Accounting $accounting): static
    {
        if ($this->accountings->removeElement($accounting)) {
            // set the owning side to null (unless already changed)
            if ($accounting->getEvent() === $this) {
                $accounting->setEvent(null);
            }
        }

        return $this;
    }

}
