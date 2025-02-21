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
        $agent->setEntryDate(new \DateTime());
        $agent->setRoles(['ROLE_AGENT']); // ✅ Correction ici

        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agent->setPassword($passwordHasher->hashPassword($agent, $agent->getPassword()));
            $em->persist($agent);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/signup/student', name: 'signup_student')]
    public function registerStudent(
        Request $request, 
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $student = new Student();
        $student->setEntryDate(new \DateTime());
        $student->setRoles(['ROLE_STUDENT']); // ✅ Correction ici

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $student->setPassword($passwordHasher->hashPassword($student, $student->getPassword()));

            // Enregistrement en base de données
            $em->persist($student);
            $em->flush();

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
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $tutor = new Tutor();
        $tutor->setEntryDate(new \DateTime());
        $tutor->setRoles(['ROLE_TUTOR']); // ✅ Correction ici

        $form = $this->createForm(TutorType::class, $tutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $tutor->setPassword($passwordHasher->hashPassword($tutor, $tutor->getPassword()));

            // Enregistrement en base de données
            $em->persist($tutor);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/newT.html.twig', [
            'form' => $form->createView(),
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
}
