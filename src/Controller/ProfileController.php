<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;




class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
public function viewProfile(): Response
{
    // Vérifier si l'utilisateur est authentifié
    $user = $this->getUser();

    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    if (!$user) {
        return $this->redirectToRoute('app_login');
    }

    // Rendre la vue avec les informations de l'utilisateur
    return $this->render('profile/view.html.twig', [
        'user' => $user,
    ]);
}


    #[Route('/profile/edit', name: 'app_profile_edit')]
public function editProfile(Request $request, EntityManagerInterface $entityManager): Response
{
    // Récupérer l'utilisateur actuellement connecté
    $user = $this->getUser();

    // Créer un formulaire pour modifier son profil
    $form = $this->createForm(ProfileType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Sauvegarder les modifications dans la base de données
        $entityManager->flush();

        // Ajouter un message de succès
        $this->addFlash('success', 'Profil mis à jour avec succès !');

        // Rediriger vers la page du profil
        return $this->redirectToRoute('app_profile');
    }

    return $this->render('profile/index.html.twig', [
        'form' => $form->createView(),
    ]);
}

}