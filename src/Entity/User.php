<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[RollerworksPassword\PasswordRequirements(
        minLength: 8,
        requireLetters: true,
        tooShortMessage: "Votre mot de passe doit faire au moins 8 caractères",
        missingLettersMessage: "Votre mot de passe doit contenir au moins 1 lettre"
    )]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Bien::class)]
    private Collection $biens;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoProfil = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: BienUser::class)]

    private Collection $bienUsers;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
        $this->bienUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, BienUser>
     */
    public function getBienUsers(): Collection
    {
        return $this->bienUsers;
    }

    public function addBienUser(BienUser $bienUser): static
    {
        if (!$this->bienUsers->contains($bienUser)) {
            $this->bienUsers->add($bienUser);
            $bienUser->setUser($this);
        }

        return $this;
    }

    public function removeBienUser(BienUser $bienUser): static
    {
        if ($this->bienUsers->removeElement($bienUser)) {
            // set the owning side to null (unless already changed)
            if ($bienUser->getUser() === $this) {
                $bienUser->setUser(null);
            }
        }

        return $this;
    }
}
