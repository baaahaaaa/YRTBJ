<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Internship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackOfficeController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // Ici, vous pouvez ajouter de la logique pour afficher des données spécifiques du dashboard.
        return $this->render('back_office/index.html.twig');
    }

}