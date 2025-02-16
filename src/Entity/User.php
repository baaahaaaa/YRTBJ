<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["admin" => "Admin", "student" => "Student", "tutor" => "Tutor", "agent" => "Agent"])]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50, minMessage: "Le prénom doit contenir au moins {{ limit }} caractères.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÖØ-öø-ÿ -]+$/u",
        message: "Le prénom ne peut contenir que des lettres et des espaces."
    )]
    protected ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50, minMessage: "Le nom doit contenir au moins {{ limit }} caractères.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÖØ-öø-ÿ -]+$/u",
        message: "Le nom ne peut contenir que des lettres et des espaces."
    )]
    protected ?string $LastName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'email {{ value }} n'est pas valide.")]
    protected ?string $Email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "La date d'entrée est obligatoire.")]
    #[Assert\Type(type: "\DateTimeInterface", message: "La date d'entrée doit être une date valide.")]
    protected ?\DateTimeInterface $Entry_Date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(
        min: 8,
        minMessage: "Votre mot de passe doit contenir au moins {{ limit }} caractères."
    )]
    protected ?string $Password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le rôle est obligatoire.")]
    #[Assert\Choice(choices: ['Agent', 'Student', 'Tutor'], message: "Le rôle doit être Agent, Student ou Tutor.")]
    protected ?string $Role = null;

    public function __construct()
    {
        $this->Entry_Date = new \DateTime(); // Définit la date du jour par défaut
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
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

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

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }
    protected ?string $domain = null;

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }
}
 





