<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["admin" => "Admin", "student" => "Student", "tutor" => "Tutor", "agent" => "Agent"])]
class User implements UserInterface , PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50)]
    protected ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50)]
    protected ?string $LastName = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email]
    protected ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    protected ?\DateTimeInterface $Entry_Date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(min: 8, minMessage: "Votre mot de passe doit contenir au moins {{ limit }} caractères.")]
    protected ?string $Password = null;

    public function __construct()
    {
        $this->Entry_Date = new \DateTime(); // Définit la date du jour par défaut
        $this->roles = ['ROLE_ADMIN']; // Par défaut, un seul rôle admin
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;
        return $this;
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

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->Entry_Date;
    }

    public function setEntryDate(\DateTimeInterface $Entry_Date): static
    {
        $this->Entry_Date = $Entry_Date;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;
        return $this;
    }
    public function getRoles(): array
    {
        // Retourne un tableau de rôles, Symfony attend un tableau et non une chaîne
        return $this->roles ?? ['ROLE_USER'];
    }
    
    public function setRoles(array $roles): self
{
    $this->roles = $roles;
    return $this;
}
    public function getUserIdentifier(): string
    {
        return $this->email; // Symfony utilise l'email comme identifiant unique
    }

    public function eraseCredentials()
    {
        // S'il y a des données sensibles stockées temporairement, on les efface ici
    }
}
