<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        echo "🚀 Début du chargement des fixtures...\n";
    
        $existingAdmin = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@example.com']);

       if (!$existingAdmin) {
            echo "✅ Création de l'admin...\n";
    
            $admin = new User();
            $admin->setFirstName('Admin');
            $admin->setLastName('User');
            $admin->setEmail('admin@example.com');
            $admin->setEntryDate(new \DateTime()); // Date actuelle
            $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpassword'));           
            $admin->setRoles(['ROLE_ADMIN']); // Ajout du rôle admin
            $hashedPassword = $this->passwordHasher->hashPassword($admin, 'adminpassword');
             echo "🔑 Mot de passe haché : $hashedPassword\n";
            $admin->setPassword($hashedPassword);
            $manager->persist($admin);
            $manager->flush();
            $manager->clear();
    
            echo "🎉 Admin inséré avec succès !\n";
        } else {
            echo "⚠️ Un administrateur existe déjà, pas de nouvelle insertion.\n";
        }
    }
    }
