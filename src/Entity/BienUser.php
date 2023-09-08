<?php

namespace App\Entity;

use App\Repository\BienUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BienUserRepository::class)]
class BienUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bienUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bien $bien = null;

    #[ORM\ManyToOne(inversedBy: 'bienUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAcces = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function setBien(?Bien $bien): static
    {
        $this->bien = $bien;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDateAcces(): ?\DateTimeInterface
    {
        return $this->dateAcces;
    }

    public function setDateAcces(\DateTimeInterface $dateAcces): static
    {
        $this->dateAcces = $dateAcces;

        return $this;
    }
}
