<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Reclamation;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reponse')]
final class ReponseController extends AbstractController
{
    #[Route('/', name: 'app_reponse_index', methods: ['GET'])]
    public function index(ReponseRepository $reponseRepository, ReclamationRepository $reclamationRepository): Response
    {
        // Récupération de toutes les réponses et réclamations
        $reponses = $reponseRepository->findAll();
        $reclamations = $reclamationRepository->findAll();
    
        return $this->render('reponse/index.html.twig', [
            'reclamations' => $reclamations,
            'reponses'     => $reponses,
        ]);
    }
    
    #[Route('/new', name: 'app_reponse_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Affectation de la date de création si non définie
            if (null === $reponse->getCreatedAt()) {
                $reponse->setCreatedAt(new \DateTimeImmutable());
            }
    
            // Persistance et sauvegarde de la réponse
            $entityManager->persist($reponse);
            $entityManager->flush();
    
            // Récupération de la réclamation associée et de son email
            $reclamation = $reponse->getReclamation();
            if ($reclamation && $reclamation->getEmail()) {
                $emailAdresse = $reclamation->getEmail();
                dump('Envoi de l’email vers : ' . $emailAdresse); // Pour vérifier
    
                // Création et envoi de l'email
                $email = (new Email())
                    ->from('tasnim.araar@esprit.tn') // Adresse de l'expéditeur
                    ->to($emailAdresse)
                    ->subject('Réponse à votre réclamation')
                    ->html(
                        '<p>Bonjour,</p>' .
                        '<p>Votre réclamation a reçu une réponse :</p>' .
                        '<blockquote>' . nl2br($reponse->getDescription()) . '</blockquote>' .
                        '<p>Cordialement,<br>L’équipe support</p>'
                    );
    
                $mailer->send($email);
                dump('Email envoyé.'); // Pour confirmer que l'envoi a été déclenché
            }
    
            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('reponse/new.html.twig', [
            'reponse' => $reponse,
            'form'    => $form->createView(),
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
            'form'    => $form->createView(),
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
