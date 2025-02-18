<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Title cannot be blank.")]
    #[Assert\Length(min: 3, max: 255, minMessage: "Title should be at least 3 characters.", maxMessage: "Title should not exceed 255 characters.")]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Description cannot be blank.")]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Format cannot be blank.")]
    private ?string $Format = null;

    #[Assert\NotBlank(message: "date cannot be blank.")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $CreationDate = null;

    #[ORM\ManyToOne(inversedBy: 'ressources')]
    #[Assert\NotNull(message: "The course field cannot be null.")]
    private ?Course $courses = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $filePath = null;

    #[Assert\File(
        maxSize: "5M",
        mimeTypes: ["application/pdf", "image/jpeg", "image/png", "application/msword"],
        mimeTypesMessage: "Veuillez télécharger un fichier valide (PDF, JPG, PNG, DOC)."
    )]
    private ?File $file = null;

    // ✅ GETTERS & SETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;
        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->Format;
    }

    public function setFormat(string $Format): self
    {
        $this->Format = $Format;
        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(?\DateTimeInterface $CreationDate): self
    {
        $this->CreationDate = $CreationDate;
        return $this;
    }

    public function getCourses(): ?Course
    {
        return $this->courses;
    }

    public function setCourses(?Course $courses): self
    {
        $this->courses = $courses;
        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }
}