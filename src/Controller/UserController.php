<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\TutorType;
use App\Form\UserType;
use App\Entity\Agent;
use App\Form\AgentType;
use App\Entity\Student;
use App\Entity\Tutor;
use App\Form\StudentType;
use App\Form\InviteTutorType;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport\SmtpTransport;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/signup/agent', name: 'signup_agent')]
    public function registerAgent(
        Request $request, 
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $agent = new Agent();
        $agent->setEntryDate(new \DateTime()); // Définit une date d'entrée par défaut
        $agent->setRole('ROLE_AGENT'); // Définit le rôle par défaut
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agent->setPassword($passwordHasher->hashPassword($agent, $agent->getPassword()));
            $em->persist($agent);
            $em->flush();

            return $this->redirectToRoute(route: 'app_user_index');
        }

        return $this->render('user/new.html.twig', ['form' => $form->createView()]);
    }
    
    #[Route('/signup/student', name: 'signup_student')]
public function registerStudent(
    Request $request, 
    EntityManagerInterface $em, 
    UserPasswordHasherInterface $passwordHasher,
    ValidatorInterface $validator // Ajout du validateur pour gérer les erreurs
): Response {
    $student = new Student();
    $student->setEntryDate(new \DateTime()); // Définit une date d'entrée par défaut
    $student->setRole('ROLE_STUDENT'); // Définit le rôle par défaut

    $form = $this->createForm(StudentType::class, $student);
    $form->handleRequest($request);

    if ($form->isSubmitted()) {
        // Vérification des erreurs de validation
        $errors = $validator->validate($student);

        if (count($errors) > 0) {
            return $this->render('user/newS.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors, // Envoie les erreurs à Twig
            ]);
        }

        // Hash du mot de passe
        $student->setPassword($passwordHasher->hashPassword($student, $student->getPassword()));

        // Enregistrement en base de données
        $em->persist($student);
        $em->flush();

        return $this->redirectToRoute('app_user_index');
    }

    return $this->render('user/newS.html.twig', [
        'form' => $form->createView(),
        'errors' => null, // S'assure que la variable existe dans le template
    ]);
}


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
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

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_user_index'); // Redirection après suppression
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/signup/tutor', name: 'signup_tutor')]

    public function registerTutor(
        Request $request, 
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator // Ajout du validateur pour gérer les erreurs
    ): Response {
        $tutor = new Tutor();
        $tutor->setEntryDate(new \DateTime()); // Définit une date d'entrée par défaut
        $tutor->setRole('Tutor'); // Définit le rôle par défaut
    
        $form = $this->createForm(TutorType::class, $tutor);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            // Vérification des erreurs de validation
            $errors = $validator->validate($tutor);
    
            if (count($errors) > 0) {
                return $this->render('user/newT.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $errors, // Envoie les erreurs à Twig
                ]);
            }
    
            // Hash du mot de passe
            $tutor->setPassword($passwordHasher->hashPassword($tutor, $tutor->getPassword()));
    
            // Enregistrement en base de données
            $em->persist($tutor);
            $em->flush();
    
            return $this->redirectToRoute('app_user_index');
        }
    
        return $this->render('user/newT.html.twig', [
            'form' => $form->createView(),
            'errors' => null, // S'assure que la variable existe dans le template
        ]);
    }
   

}
