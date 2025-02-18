<?php

namespace App\Controller;

use App\Entity\Internship;
use App\Form\InternshipType;
use App\Repository\InternshipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface; // Ajout pour la validation


/*affiche table de internships dans le back*/
#[Route('/internship')]
final class InternshipController extends AbstractController
{
    #[Route(name: 'app_internship_index', methods: ['GET'])]
    public function index(InternshipRepository $internshipRepository): Response
    {
        return $this->render('internship/index.html.twig', [
            'internships' => $internshipRepository->findAll(),
        ]);
    }
/*affiche table de internships dans le Front */

    #[Route('/internships', name: 'app_internship_show_all', methods: ['GET'])]
public function showAllInternships(InternshipRepository $internshipRepository): Response
{
    $internships = $internshipRepository->findAll();
    return $this->render('internship/indexfront.html.twig', [
        'internships' => $internships,
    ]);
}

/* Création de internship offer dans le back */

    #[Route('/new', name: 'app_internship_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $internship = new Internship();
        $form = $this->createForm(InternshipType::class, $internship);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Validation manuelle de l'entité
            $errors = $validator->validate($internship);

            if (count($errors) > 0) {
                // Si des erreurs sont détectées, nous retournons les erreurs dans la vue
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }

                return $this->render('internship/new.html.twig', [
                    'internship' => $internship,
                    'form' => $form,
                    'errors' => $errorMessages, // Passer les erreurs à la vue
                ]);
            }

            // Si le formulaire est valide et pas d'erreurs de validation, persister l'entité
            $entityManager->persist($internship);
            $entityManager->flush();

            return $this->redirectToRoute('app_internship_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('internship/new.html.twig', [
            'internship' => $internship,
            'form' => $form,
        ]);
    }

    /*Affichage de détails d'un internship dans front */
    #[Route('/show/{id}', name: 'app_internship_show', methods: ['GET'])]
    public function showFront(Internship $internship): Response
    {
        return $this->render('internship/showfront.html.twig', [
            'internship' => $internship,
        ]);
    }

    /*Affichage de détails d'un internship dans back */
    #[Route('/admin/show/{id}', name: 'app_admin_internship_show', methods: ['GET'])]
    public function showBack(Internship $internship): Response
    {
        return $this->render('internship/show.html.twig', [
            'internship' => $internship,
        ]);
    }
    /*Modification de inetrnhsip en back */

    #[Route('/{id}/edit', name: 'app_internship_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Internship $internship, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        // Créer le formulaire pour l'internship à modifier
        $form = $this->createForm(InternshipType::class, $internship);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            // Validation manuelle de l'entité
            $errors = $validator->validate($internship);
    
            if (count($errors) > 0) {
                // Si des erreurs sont détectées, retourner les erreurs dans la vue
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
    
                return $this->render('internship/edit.html.twig', [
                    'internship' => $internship,
                    'form' => $form->createView(), // Passer correctement le formulaire à la vue
                    'errors' => $errorMessages, // Passer les erreurs à la vue
                ]);
            }
    
            // Si le formulaire est valide et pas d'erreurs de validation, enregistrer les modifications
            $entityManager->flush();
    
            return $this->redirectToRoute('app_internship_index', [], Response::HTTP_SEE_OTHER);
        }
    
        // Rendre la vue avec le formulaire et l'internship
        return $this->render('internship/edit.html.twig', [
            'internship' => $internship,
            'form' => $form->createView(), // Passer correctement le formulaire à la vue
        ]);
    }
    

 /*  effacer le internship dans le back */

    #[Route('/{id}', name: 'app_internship_delete', methods: ['POST'])]
    public function delete(Request $request, Internship $internship, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$internship->getId(), $request->request->get('_token'))) {
            $entityManager->remove($internship);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_internship_index', [], Response::HTTP_SEE_OTHER);
    }
}