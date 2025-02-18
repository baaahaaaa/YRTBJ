<?php

namespace App\Entity;

use App\Repository\InternshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InternshipRepository::class)]
class Internship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The title cannot be empty.")]
    #[Assert\Length(max: 255, maxMessage: "The title cannot be longer than 255 characters.")]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The description cannot be empty.")]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The company name cannot be empty.")]
    private ?string $CompanyName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The location cannot be empty.")]
    private ?string $Location = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The duration cannot be empty.")]
    private ?string $Duration = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The requirements cannot be empty.")]
    private ?string $Requirements = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The email cannot be empty.")]
    #[Assert\Email(message: "Please enter a valid email address.")]
    private ?string $Email = null;

    /**
     * @var Collection<int, Candidat>
     */
    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'internship')]
    private Collection $candidats;

    #[ORM\ManyToOne(inversedBy: 'internships')]
    private ?Agent $agent = null;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
    }

    // Getters and setters (avec validations intégrées)

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;
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

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(string $Location): static
    {
        $this->Location = $Location;
        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->Duration;
    }

    public function setDuration(string $Duration): static
    {
        $this->Duration = $Duration;
        return $this;
    }

    public function getRequirements(): ?string
    {
        return $this->Requirements;
    }

    public function setRequirements(string $Requirements): static
    {
        $this->Requirements = $Requirements;
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

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): static
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats->add($candidat);
            $candidat->setInternship($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): static
    {
        if ($this->candidats->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getInternship() === $this) {
                $candidat->setInternship(null);
            }
        }

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;
        return $this;
    }
}