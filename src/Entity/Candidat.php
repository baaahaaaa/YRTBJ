<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "The application date cannot be null.")]
    #[Assert\LessThanOrEqual(
        value: "today",
        message: "The application date cannot be in the future."
    )]
    private ?\DateTimeInterface $Date_candidature = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The email cannot be empty.")]
    #[Assert\Email(message: "Please enter a valid email address.")]
    private ?string $Email = null;

    #[ORM\Column(type: "string", length: 8)] // Changer le type en string
    #[Assert\NotBlank(message: "The phone number cannot be empty.")]
    #[Assert\Regex(
        pattern: "/^\d{8}$/",
        message: "The phone number must be exactly 8 digits and contain only numbers."
    )]
    private ?string $PhoneNumber = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The full name cannot be empty.")]
    #[Assert\Length(
        min: 5,
        max: 100,
        minMessage: "The full name must be at least 5 characters long.",
        maxMessage: "The full name cannot be longer than 100 characters."
    )]
    private ?string $FullName = null;

    #[ORM\Column]
    private ?bool $Result = null;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    private ?Internship $internship = null;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    private ?Student $student = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\File(
        maxSize: "2M",
        mimeTypes: ["application/pdf"],
        mimeTypesMessage: "The CV must be a PDF file with a maximum size of 2MB."
    )]
    private ?string $cvFilename = null;

    public function getCvFilename(): ?string
    {
        return $this->cvFilename;
    }

    public function setCvFilename(?string $cvFilename): self
    {
        $this->cvFilename = $cvFilename;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCandidature(): ?\DateTimeInterface
    {
        return $this->Date_candidature;
    }

    public function setDateCandidature(?\DateTimeInterface $Date_candidature): static
    {
        $this->Date_candidature = $Date_candidature;
        return $this;
    }
    public function __construct()
{
    $this->Date_candidature = new \DateTime(); // Default to the current date
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

    public function getPhoneNumber(): ?int
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(int $PhoneNumber): static
    {
        $this->PhoneNumber = $PhoneNumber;
        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->FullName;
    }

    public function setFullName(string $FullName): static
    {
        $this->FullName = $FullName;
        return $this;
    }

    public function isResult(): ?bool
    {
        return $this->Result;
    }

    public function setResult(bool $Result): static
    {
        $this->Result = $Result;
        return $this;
    }

    public function getInternship(): ?Internship
    {
        return $this->internship;
    }

    public function setInternship(?Internship $internship): static
    {
        $this->internship = $internship;
        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;
        return $this;
    }
}