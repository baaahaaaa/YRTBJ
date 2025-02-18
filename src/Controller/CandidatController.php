<?php

namespace App\Controller;
use App\Entity\Internship;
use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

 /*Affichage de table de candidatures dans le back */

#[Route('/candidat')]
final class CandidatController extends AbstractController
{
    #[Route(name: 'app_candidat_index', methods: ['GET'])]
    public function index(CandidatRepository $candidatRepository): Response
    {
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidatRepository->findAll(),
        ]);
    }

/* ajouter une candidature dans front */

    #[Route('/postuler/{id}', name: 'postuler', methods: ['GET', 'POST'])]
public function postuler(Request $request, EntityManagerInterface $entityManager, int $id): Response
{
    // Récupérer l'offre de stage à partir de son ID
    $internship = $entityManager->getRepository(Internship::class)->find($id);

    if (!$internship) {
        throw $this->createNotFoundException('Internship not found');
    }
    // Créer un objet Candidat pour le formulaire
    $candidat = new Candidat();

    // Créer et gérer le formulaire
    $form = $this->createForm(CandidatType::class, $candidat);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Traiter les fichiers (CV et lettre de motivation)

        $cvFile = $form->get('cv')->getData();
        if ($cvFile) {
            $cvFilename = uniqid().'.'.$cvFile->guessExtension();
            try {
                $cvFile->move(
                    $this->getParameter('uploads_directory'),
                    $cvFilename
                );
                $candidat->setCvFilename($cvFilename); // Enregistrer le nom du fichier dans l'entité
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors de l\'upload du fichier.');
            }
        }

        // Associer l'internship et enregistrer l'objet
        $candidat->setInternship($internship);

        $entityManager->persist($candidat);
        $entityManager->flush();

        // Ajouter un message de succès
        $this->addFlash('success', 'Votre candidature a été envoyée avec succès.');

        // Rediriger vers la liste des offres de stage
        return $this->redirectToRoute('app_internship_show_all');
    }

    // Rendre la vue avec le formulaire
    return $this->render('Candidat/apply.html.twig', [
        'internship' => $internship,
        'form' => $form->createView(),
    ]);
}

/* afficher détails de candidature dans le back */

    #[Route('/{id}/show', name: 'app_candidat_show', methods: ['GET'])]
public function show(Candidat $candidat): Response
{
    return $this->render('candidat/show.html.twig', [
        'candidat' => $candidat,
    ]);
}
public function getCoverLetterContent(): ?string
{
    $filePath = '/path/to/cover_letters/' . $this->CoverLetterFilename;
    if (file_exists($filePath)) {
        return file_get_contents($filePath);
    }
    return null;
}

/* affichage de résultat dans front */

#[Route('/{id}/result', name: 'app_candidat_result', methods: ['GET'])]
public function result(Candidat $candidat): Response
{
    return $this->render('candidat/result.html.twig', [
        'candidat' => $candidat,
    ]);
}

#[Route('/{id}/accept', name: 'app_candidat_accept', methods: ['POST'])]
public function accept(Candidat $candidat, EntityManagerInterface $entityManager): Response
{
    $candidat->setResult(true);  // Accepter le candidat
    $entityManager->flush();

    $this->addFlash('success', 'Candidat accepté avec succès.');

    return $this->redirectToRoute('app_candidat_result', ['id' => $candidat->getId()]);
}

#[Route('/{id}/reject', name: 'app_candidat_reject', methods: ['POST'])]
public function reject(Candidat $candidat, EntityManagerInterface $entityManager): Response
{
    $candidat->setResult(false);  // Rejeter le candidat
    $entityManager->flush();

    $this->addFlash('danger', 'Candidat rejeté.');

    return $this->redirectToRoute('app_candidat_result', ['id' => $candidat->getId()]);
}

    #[Route('/internship/{internshipId}/applications', name: 'app_candidat_by_internship', methods: ['GET'])]
    public function applicationsByInternship(int $internshipId, CandidatRepository $candidatRepository): Response
    {
        $candidats = $candidatRepository->findBy(['internship' => $internshipId]);
    
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidats,
        ]);
    }


   /* #[Route('/{id}/edit', name: 'app_candidat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidat/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidat_delete', methods: ['POST'])]
    public function delete(Request $request, Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($candidat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
    }

*/
}