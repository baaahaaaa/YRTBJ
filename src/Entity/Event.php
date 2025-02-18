<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le type de l'événement est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le type ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'emplacement de l'événement est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "L'emplacement ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de l'événement est obligatoire.")]
    #[Assert\Type(\DateTimeInterface::class, message: "La date n'est pas valide.")]
    #[Assert\GreaterThan("today", message: "La date de l'événement doit être dans le futur.")]
    private ?\DateTimeInterface $Date_event = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix est obligatoire.")]
    #[Assert\Type(type: 'numeric', message: "Le prix doit être un nombre.")]
    #[Assert\PositiveOrZero(message: "Le prix ne peut pas être négatif.")]
    private ?float $Price = null;

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

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;
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

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->Date_event;
    }

    public function setDateEvent(?\DateTimeInterface $Date_event): static
    {
        $this->Date_event = $Date_event;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): static
    {
        $this->Price = $Price;
        return $this;
    }
}
