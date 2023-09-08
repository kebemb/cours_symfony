<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    private ?string $codePostal = null;

    #[ORM\Column(nullable: true)]
    private ?int $superficie = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Bien::class, orphanRemoval: true)]
    private Collection $biens;

    #[ORM\ManyToMany(targetEntity: FoodTruck::class, mappedBy: 'villes')]
    private Collection $foodTrucks;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
        $this->foodTrucks = new ArrayCollection();
    }

    public function getNomCodePostal(): ?string
    {
        return $this->nom . ' - ' . $this->codePostal;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(?int $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * @return Collection<int, Bien>
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(Bien $bien): static
    {
        if (!$this->biens->contains($bien)) {
            $this->biens->add($bien);
            $bien->setVille($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): static
    {
        if ($this->biens->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getVille() === $this) {
                $bien->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FoodTruck>
     */
    public function getFoodTrucks(): Collection
    {
        return $this->foodTrucks;
    }

    public function addFoodTruck(FoodTruck $foodTruck): static
    {
        if (!$this->foodTrucks->contains($foodTruck)) {
            $this->foodTrucks->add($foodTruck);
            $foodTruck->addVille($this);
        }

        return $this;
    }

    public function removeFoodTruck(FoodTruck $foodTruck): static
    {
        if ($this->foodTrucks->removeElement($foodTruck)) {
            $foodTruck->removeVille($this);
        }

        return $this;
    }
}
