<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CourseRepository; // Ajout du repository des cours

class HomeController extends AbstractController
{
    #[Route('/Home', name: 'home')]
    public function home(CourseRepository $courseRepository): Response
    {
        // Récupérer tous les cours de la base de données
        $courses = $courseRepository->findAll();

        // Passer la variable 'courses' au template
        return $this->render('Front/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
