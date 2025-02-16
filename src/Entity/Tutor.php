<?php

namespace App\Entity;

use App\Repository\TutorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: TutorRepository::class)]
class Tutor extends User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 255)]
    private ?string $Domain = null;

    public function __contstruct()
    {
        $this->role="TUTOR";
    }

    public function getDomain(): ?string
    {
        return $this->Domain;
    }

    public function setDomain(string $Domain): static
    {
        $this->Domain = $Domain;

        return $this;
    }
}
