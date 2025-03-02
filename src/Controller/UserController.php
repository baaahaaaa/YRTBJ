<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Agent;
use App\Entity\Student;
use App\Entity\Tutor;
use App\Form\AgentType;
use App\Form\StudentType;
use App\Form\TutorType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Form\UserSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;




#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'app_user_index', methods: ['GET', 'POST'])]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        // Récupérer le terme de recherche
        $searchTerm = $request->request->get('searchTerm', '');
    
        // Construire la requête de recherche
        $queryBuilder = $userRepository->createQueryBuilder('u');
    
        if (!empty($searchTerm)) {
            $queryBuilder->andWhere('u.FirstName LIKE :search OR u.LastName LIKE :search OR u.email LIKE :search')
                         ->setParameter('search', '%' . $searchTerm . '%');
        }
    
        // Exécuter la requête
        $users = $queryBuilder->getQuery()->getResult();
    
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'searchTerm' => $searchTerm, // Pour garder la valeur après recherche
        ]);
    }
    #[Route('{id}', name: 'app_user_show', methods: ['GET'])]
public function show(User $user): Response
{
    return $this->render('user/show.html.twig', [
        'user' => $user,
    ]);
}

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index');
    }
    // Cette méthode va activer le compte de l'utilisateur en utilisant le jeton
    #[Route('/activate/{token}', name: 'app_user_activate')]
    public function activateAccount(string $token, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        // Trouver l'utilisateur par son token d'activation
        $user = $userRepository->findOneBy(['activationToken' => $token]);

        // Si aucun utilisateur n'est trouvé avec ce token, retourner un message d'erreur
        if (!$user) {
            $this->addFlash('error', 'Lien d\'activation invalide.');
            return $this->redirectToRoute('home');  // Redirige vers la page d'accueil
        }

        // Active l'utilisateur
        $user->setIsActive(true);

        // Réinitialise le token d'activation (le vide) sans assigner 'null'
        $user->setActivationToken('');  // Vous pouvez aussi utiliser '' pour vider le token

        // Sauvegarde les changements dans la base de données
        $em->flush();

        // Ajoute un message flash et redirige l'utilisateur
        $this->addFlash('success', 'Votre compte a été activé avec succès !');
        return $this->render('security/Activation_success.html.twig');
    }

    // Cette méthode envoie un e-mail d'activation à l'utilisateur
private function sendActivationEmail(User $user, MailerInterface $mailer, UrlGeneratorInterface $urlGenerator): void
{
    // Génère l'URL d'activation en utilisant le jeton de l'utilisateur
    $activationUrl = $urlGenerator->generate('app_user_activate', [
        'token' => $user->getActivationToken(),
    ], UrlGeneratorInterface::ABSOLUTE_URL);

    // Crée l'e-mails
    $email = (new Email())
        ->from('bahouta.bahouta.02@gmail.com')  // Adresse de l'expéditeur
        ->to($user->getEmail())               // Adresse de l'utilisateur
        ->subject('Activation de votre compte') // Sujet de l'e-mail
        ->html('<p>Bonjour ' . $user->getFirstName() . ',</p><p>Veuillez cliquer sur le lien suivant pour activer votre compte : <a href="' . $activationUrl . '">Activer mon compte</a></p>');

    // Envoie l'e-mail
    $mailer->send($email);
}



    #[Route('/signup/agent', name: 'signup_agent')]
    public function registerAgent(
        Request $request, 
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher,
        MailerInterface $mailer,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $agent = new Agent();
        $agent->setEntryDate(new \DateTime());
        $agent->setRoles(['ROLE_AGENT']); // Définir le rôle de l'agent

        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
        
            // Hash du mot de passe
            $agent->setPassword($passwordHasher->hashPassword($agent, $agent->getPassword()));

            // Générer le token d'activation
            $activationToken = bin2hex(random_bytes(32));
            if (empty($activationToken)) {
                throw new \Exception("Le jeton d'activation est invalide.");
            }
            $agent->setActivationToken($activationToken);

            // Enregistrement en base de données
            $em->persist($agent);
            $em->flush();

            // Envoi de l'e-mail d'activation (dynamique)
            $this->sendActivationEmail($agent, $mailer, $urlGenerator);

            // Redirection après inscription
            $this->addFlash('success', 'Un e-mail d\'activation a été envoyé.');
            return $this->redirectToRoute('home');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/signup/student', name: 'signup_student')]
    public function registerStudent(
        Request $request, 
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher,
        MailerInterface $mailer,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $student = new Student();
        $student->setEntryDate(new \DateTime());
        $student->setRoles(['ROLE_STUDENT']); // Définir le rôle de l'étudiant

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            // Hash du mot de passe
            $student->setPassword($passwordHasher->hashPassword($student, $student->getPassword()));

            // Générer le token d'activation
            $activationToken = bin2hex(random_bytes(32));
            if (empty($activationToken)) {
                throw new \Exception("Le jeton d'activation est invalide.");
            }
            $student->setActivationToken($activationToken);

            // Enregistrement en base de données
            $em->persist($student);
            $em->flush();

            // Envoi de l'e-mail d'activation (dynamique)
            $this->sendActivationEmail($student, $mailer, $urlGenerator);

            // Redirection après inscription
            $this->addFlash('success', 'Un e-mail d\'activation a été envoyé.');
            return $this->redirectToRoute('home');
        }

        return $this->render('user/newS.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/signup/tutor', name: 'signup_tutor')]
    public function registerTutor(
        Request $request, 
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher,
        MailerInterface $mailer,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $tutor = new Tutor();
        $tutor->setEntryDate(new \DateTime());
        $tutor->setRoles(['ROLE_TUTOR']); // Définir le rôle du tuteur

        $form = $this->createForm(TutorType::class, $tutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            // Hash du mot de passe
            $tutor->setPassword($passwordHasher->hashPassword($tutor, $tutor->getPassword()));

            // Générer le token d'activation
            $activationToken = bin2hex(random_bytes(32));
            if (empty($activationToken)) {
                throw new \Exception("Le jeton d'activation est invalide.");
            }
            $tutor->setActivationToken($activationToken);

            // Enregistrement en base de données
            $em->persist($tutor);
            $em->flush();

            // Envoi de l'e-mail d'activation (dynamique)
            $this->sendActivationEmail($tutor, $mailer, $urlGenerator);

            // Redirection après inscription
            $this->addFlash('success', 'Un e-mail d\'activation a été envoyé.');
            return $this->redirectToRoute('home');
        }

        return $this->render('user/newT.html.twig', [
            'form' => $form->createView(),
        ]);

    }
   
}