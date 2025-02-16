<?php

namespace App\Entity;

use App\Repository\ComplaintResponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplaintResponseRepository::class)]
class ComplaintResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Response = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateResponse = null;

    #[ORM\Column(length: 255)]
    private ?string $Email_sender = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?string
    {
        return $this->Response;
    }

    public function setResponse(string $Response): static
    {
        $this->Response = $Response;

        return $this;
    }

    public function getDateResponse(): ?\DateTimeInterface
    {
        return $this->DateResponse;
    }

    public function setDateResponse(\DateTimeInterface $DateResponse): static
    {
        $this->DateResponse = $DateResponse;

        return $this;
    }

    public function getEmailSender(): ?string
    {
        return $this->Email_sender;
    }

    public function setEmailSender(string $Email_sender): static
    {
        $this->Email_sender = $Email_sender;

        return $this;
    }

}
