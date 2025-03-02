<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent extends User implements PasswordAuthenticatedUserInterface
{
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50, minMessage: "Le prénom doit contenir au moins {{ limit }} caractères.")]
    protected ?string $FirstName = null;

    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50, minMessage: "Le nom doit contenir au moins {{ limit }} caractères.")]
    protected ?string $LastName = null;
    public function getRoles(): array
    {
        return ['ROLE_AGENT']; // Change selon la cl    asse
    }
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La localisation ne peut pas être vide.")]
    #[Assert\Length(
    max: 255,
    maxMessage: "La localisation ne peut pas dépasser 255 caractères."
)]
    private ?string $Location = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'entreprise ne peut pas être vide.")]
#[Assert\Length(
    max: 255,
    maxMessage: "Le nom de l'entreprise ne peut pas dépasser 255 caractères."
)]
    private ?string $CompanyName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(string $Location): static
    {
        $this->Location = $Location;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(string $CompanyName): static
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }
}
