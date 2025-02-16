<?php

namespace App\Entity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student extends User implements PasswordAuthenticatedUserInterface
{
        
    public function __contstruct()
    {
        $this->role="ROLE_STUDENT";
    }
}
