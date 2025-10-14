<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codepos = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    /**
     * @var Collection<int, Contact>
     */
    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'family', orphanRemoval: true)]
    private Collection $contacts;

    /**
     * @var Collection<int, Racer>
     */
    #[ORM\OneToMany(targetEntity: Racer::class, mappedBy: 'family', orphanRemoval: true)]
    private Collection $racers;

    /**
     * @var Collection<int, accounting>
     */
    #[ORM\OneToMany(targetEntity: Accounting::class, mappedBy: 'family', orphanRemoval: true)]
    private Collection $accountings;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->racers = new ArrayCollection();
        $this->accountings = new ArrayCollection();
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

    public function getadress1(): ?string
    {
        return $this->adress1;
    }

    public function setadress1(?string $adress1): static
    {
        $this->adress1 = $adress1;

        return $this;
    }

    public function getadress2(): ?string
    {
        return $this->adress2;
    }

    public function setadress2(?string $adress2): static
    {
        $this->adress2 = $adress2;

        return $this;
    }

    public function getCodepos(): ?string
    {
        return $this->codepos;
    }

    public function setCodepos(?string $codepos): static
    {
        $this->codepos = $codepos;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setFamily($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getFamily() === $this) {
                $contact->setFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Racer>
     */
    public function getRacers(): Collection
    {
        return $this->racers;
    }

    public function addRacer(Racer $racer): static
    {
        if (!$this->racers->contains($racer)) {
            $this->racers->add($racer);
            $racer->setFamily($this);
        }

        return $this;
    }

    public function removeRacer(Racer $racer): static
    {
        if ($this->racers->removeElement($racer)) {
            // set the owning side to null (unless already changed)
            if ($racer->getFamily() === $this) {
                $racer->setFamily(null);
            }
        }

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
            $accounting->setFamily($this);
        }

        return $this;
    }

    public function removeAccounting(Accounting $accounting): static
    {
        if ($this->accountings->removeElement($accounting)) {
            // set the owning side to null (unless already changed)
            if ($accounting->getFamily() === $this) {
                $accounting->setFamily(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
