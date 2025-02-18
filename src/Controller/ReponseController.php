<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Reclamation;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reponse')]
final class ReponseController extends AbstractController
{
    #[Route(name: 'app_reponse_index', methods: ['GET'])]
    public function index(ReponseRepository $reponseRepository, ReclamationRepository $reclamationRepository): Response
    {
        // Récupération de toutes les réponses
        $reponses = $reponseRepository->findAll();
    
        // Récupération de toutes les réclamations
        $reclamations = $reclamationRepository->findAll();
    
        // Passage des variables au template
        return $this->render('reponse/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),

            'reponses' => $reponseRepository->findAll(),  // Assurez-vous que cette ligne est présente
        ]);
    }
    

    #[Route('/new/{ReclamationId}', name: 'app_reponse_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, ReclamationRepository $reclamtionRepository, int $ReclamationId = null): Response
{
    // Si ReclamationId est fourni, récupérez la réclamation associée
    $reclamation = $ReclamationId ? $entityManager->getRepository(Reclamation::class)->find($ReclamationId) : null;
    $reponse = new Reponse();
    $form = $this->createForm(ReponseType::class, $reponse);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $reponse->setCreatedAt(new \DateTimeImmutable());
        if ($reclamation) {
            $reclamation->setUpdatedAt(new \DateTime());
            $reclamation->setStatut('Résolu');
            $reclamation->addReponse($reponse);
            $entityManager->persist($reclamation);
            $entityManager->flush();
            $reponse->setReclamation($reclamation);
        }
        $entityManager->persist($reponse);
        $entityManager->flush();

        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('reponse/new.html.twig', [
        'reponse' => $reponse,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_reponse_show', methods: ['GET'])]
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_reponse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_delete', methods: ['POST'])]
    public function delete(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }
    
}