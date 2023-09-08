<?php

namespace App\Entity;

use App\Repository\FoodTruckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodTruckRepository::class)]
class FoodTruck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $typeCuisine = null;

    #[ORM\ManyToMany(targetEntity: Ville::class, inversedBy: 'foodTrucks')]
    private Collection $villes;

    public function __construct()
    {
        $this->villes = new ArrayCollection();
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

    public function getTypeCuisine(): ?string
    {
        return $this->typeCuisine;
    }

    public function setTypeCuisine(string $typeCuisine): static
    {
        $this->typeCuisine = $typeCuisine;

        return $this;
    }

    /**
     * @return Collection<int, Ville>
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): static
    {
        if (!$this->villes->contains($ville)) {
            $this->villes->add($ville);
        }

        return $this;
    }

    public function removeVille(Ville $ville): static
    {
        $this->villes->removeElement($ville);

        return $this;
    }
}
