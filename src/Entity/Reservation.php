<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NbPlaces = null;

    #[ORM\Column]
    private ?float $Total_price = null;

    #[ORM\Column]
    private ?int $PhoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $SpecialRequest = null;

    #[ORM\ManyToOne(targetEntity: Event::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPlaces(): ?int
    {
        return $this->NbPlaces;
    }

    public function setNbPlaces(int $NbPlaces): static
    {
        $this->NbPlaces = $NbPlaces;
        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->Total_price;
    }

    public function setTotalPrice(float $Total_price): static
    {
        $this->Total_price = $Total_price;
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

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;
        return $this;
    }

    public function getSpecialRequest(): ?string
    {
        return $this->SpecialRequest;
    }

    public function setSpecialRequest(string $SpecialRequest): static
    {
        $this->SpecialRequest = $SpecialRequest;
        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;
        return $this;
    }
}