<?php

namespace App\Entity;

use App\Repository\RacerRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[ORM\Entity(repositoryClass: RacerRepository::class)]
class Racer implements BlameableInterface
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $sex = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $birthDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $licenseNumber = null;

    #[ORM\Column]
    private ?bool $sntf = false;

    #[ORM\Column]
    private ?bool $isRacer = false;

    #[ORM\Column]
    private ?bool $isSkiInstructor = false;

    #[ORM\Column]
    private ?bool $isSkiCoach = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $isSkiInstructorLocation = null;

    #[ORM\Column]
    private ?bool $licenseActivated = false;

    #[ORM\Column(length: 255)]
    private ?string $licenseType = null;

    #[ORM\Column]
    private ?bool $clubActivated = false;

    #[ORM\Column]
    private ?bool $medicalActivated = false;

    #[ORM\Column]
    private ?bool $applyActivated = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $medical = null;

    #[ORM\Column(nullable: true)]
    private ?int $size = null;

    #[ORM\Column(nullable: true)]
    private ?int $weight = null;

    #[ORM\ManyToOne(inversedBy: 'racers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $family = null;

    /**
 * @var Collection<int, Accounting>
     */
    #[ORM\OneToMany(targetEntity: Accounting::class, mappedBy: 'racer', orphanRemoval: true)]
    private Collection $accountings;

    /**
     * @var Collection<int, EventRacer>
     */
    #[ORM\OneToMany(targetEntity: EventRacer::class, mappedBy: 'racer', orphanRemoval: true)]
    private Collection $EventRacers;

    /**
     * @var Collection<int, SkidayRacer>
     */
    #[ORM\OneToMany(targetEntity: SkidayRacer::class, mappedBy: 'racer', orphanRemoval: true)]
    private Collection $SkidayRacers;

    /**
     * @var Collection<int, AccomodationRacer>
     */
    #[ORM\OneToMany(targetEntity: AccomodationRacer::class, mappedBy: 'racer', orphanRemoval: true)]
    private Collection $accomodationsRacers;

    /**
     * @var Collection<int, TransportRacer>
     */
    #[ORM\OneToMany(targetEntity: TransportRacer::class, mappedBy: 'racer', orphanRemoval: true)]
    private Collection $transportRacers;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;



    public function __construct()
    {
        $this->accountings = new ArrayCollection();
        $this->EventRacers = new ArrayCollection();
        $this->SkidayRacers = new ArrayCollection();
        $this->accomodationsRacers = new ArrayCollection();
        $this->transportRacers = new ArrayCollection();
    }


    public function __toString(): string
    {
        return $this->getName().' '.$this->getFamily()->getName().' ('.$this->getFfsCategory().')';
    }

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

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTime $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(string $licenseNumber): static
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    public function isSntf(): ?bool
    {
        return $this->sntf;
    }

    public function setSntf(bool $sntf): static
    {
        $this->sntf = $sntf;

        return $this;
    }

    public function isRacer(): ?bool
    {
        return $this->isRacer;
    }

    public function setIsRacer(bool $isRacer): static
    {
        $this->isRacer = $isRacer;

        return $this;
    }

    public function isSkiCoach(): ?bool
    {
        return $this->isSkiCoach;
    }

    public function setIsSkiCoach(bool $isSkiCoach): static
    {
        $this->isSkiCoach = $isSkiCoach;

        return $this;
    }

    public function getIsSkiInstructorLocation(): ?string
    {
        return $this->isSkiInstructorLocation;
    }

    public function setIsSkiInstructorLocation(string $isSkiInstructorLocation): static
    {
        $this->isSkiInstructorLocation = $isSkiInstructorLocation;

        return $this;
    }

    public function isLicenseActivated(): ?bool
    {
        return $this->licenseActivated;
    }

    public function setLicenseActivated(bool $licenseActivated): static
    {
        $this->licenseActivated = $licenseActivated;

        return $this;
    }

    public function getLicenseType(): ?string
    {
        return $this->licenseType;
    }

    public function setLicenseType(string $licenseType): static
    {
        $this->licenseType = $licenseType;

        return $this;
    }

    public function isClubActivated(): ?bool
    {
        return $this->clubActivated;
    }

    public function setClubActivated(bool $clubActivated): static
    {
        $this->clubActivated = $clubActivated;

        return $this;
    }

    public function isMedicalActivated(): ?bool
    {
        return $this->medicalActivated;
    }

    public function setMedicalActivated(bool $medicalActivated): static
    {
        $this->medicalActivated = $medicalActivated;

        return $this;
    }

    public function isApplyActivated(): ?bool
    {
        return $this->applyActivated;
    }

    public function setApplyActivated(bool $applyActivated): static
    {
        $this->applyActivated = $applyActivated;

        return $this;
    }

    public function getMedical(): ?string
    {
        return $this->medical;
    }

    public function setMedical(string $medical): static
    {
        $this->medical = $medical;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): static
    {
        $this->family = $family;

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
            $accounting->setRacer($this);
        }

        return $this;
    }

    public function removeAccounting(Accounting $accounting): static
    {
        if ($this->accountings->removeElement($accounting)) {
            // set the owning side to null (unless already changed)
            if ($accounting->getRacer() === $this) {
                $accounting->setRacer(null);
            }
        }

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
            $eventRacer->setRacer($this);
        }

        return $this;
    }

    public function removeEventRacer(EventRacer $eventRacer): static
    {
        if ($this->EventRacers->removeElement($eventRacer)) {
            // set the owning side to null (unless already changed)
            if ($eventRacer->getRacer() === $this) {
                $eventRacer->setRacer(null);
            }
        }

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
            $skidayRacer->setRacer($this);
        }

        return $this;
    }

    public function removeSkidayRacer(SkidayRacer $skidayRacer): static
    {
        if ($this->SkidayRacers->removeElement($skidayRacer)) {
            // set the owning side to null (unless already changed)
            if ($skidayRacer->getRacer() === $this) {
                $skidayRacer->setRacer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AccomodationRacer>
     */
    public function getAccomodationsRacers(): Collection
    {
        return $this->accomodationsRacers;
    }

    public function addAccomodationsRacer(AccomodationRacer $accomodationsRacer): static
    {
        if (!$this->accomodationsRacers->contains($accomodationsRacer)) {
            $this->accomodationsRacers->add($accomodationsRacer);
            $accomodationsRacer->setRacer($this);
        }

        return $this;
    }

    public function removeAccomodationsRacer(AccomodationRacer $accomodationsRacer): static
    {
        if ($this->accomodationsRacers->removeElement($accomodationsRacer)) {
            // set the owning side to null (unless already changed)
            if ($accomodationsRacer->getRacer() === $this) {
                $accomodationsRacer->setRacer(null);
            }
        }

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
            $transportRacer->setRacer($this);
        }

        return $this;
    }

    public function removeTransportRacer(TransportRacer $transportRacer): static
    {
        if ($this->transportRacers->removeElement($transportRacer)) {
            // set the owning side to null (unless already changed)
            if ($transportRacer->getRacer() === $this) {
                $transportRacer->setRacer(null);
            }
        }

        return $this;
    }

    public function isSkiInstructor(): ?bool
    {
        return $this->isSkiInstructor;
    }

    public function setIsSkiInstructor(bool $isSkiInstructor): static
    {
        $this->isSkiInstructor = $isSkiInstructor;

        return $this;
    }

    public function getAgeAtDay(datetime $dayDate): int
    {
        $interval = $this->getBirthDate()->diff($dayDate);
        return (int)$interval->format('%y');
    }

    public function getFfsCategory(): ?string
    {
        $season = 0;
        $categ = "";
        $currentYear = (int)date('Y'); // 2025 pour 25/26
        $currentMonth = (int)date('m');
        if ($currentMonth > 8)
            $season = $currentYear;
        else
            $season = $currentYear - 1;

        $birthYear = (int)$this->getBirthDate()->format("Y");

        $delta = $currentYear - $birthYear;
        switch ($delta) {
            case 6:
            case 7:
                $categ = "U8";
                break;
            case 8:
            case 9:
                $categ = "U10";
            break;
            case 10:
            case 11:
                $categ = "U12";
            break;
            case 12:
            case 13:
                $categ = "U14";
            break;
            case 14:
            case 15:
                $categ = "U16";
            break;
            case 16:
            case 17:
                $categ = "U18";
            break;
            case 18:
            case 19:
            case 20:
                $categ = "U21";
            break;
            case ($delta > 20 and $delta < 30):
                $categ = "U30";
                break;
            case ($delta > 29 and $delta < 54):
                $categ = "Master M";
                break;
            default:
                $categ = "Master V";

        }
        return $categ;
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
