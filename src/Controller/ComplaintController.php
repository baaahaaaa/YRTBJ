<?php

namespace App\Controller;

use App\Entity\Complaint;
use App\Form\ComplaintType;
use App\Repository\ComplaintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/complaint')]
final class ComplaintController extends AbstractController
{
    #[Route(name: 'app_complaint_index', methods: ['GET'])]
    public function index(ComplaintRepository $complaintRepository): Response
    {
        return $this->render('complaint/index.html.twig', [
            'complaints' => $complaintRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_complaint_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $complaint = new Complaint();
        $form = $this->createForm(ComplaintType::class, $complaint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($complaint);
            $entityManager->flush();

            return $this->redirectToRoute('app_complaint_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('complaint/new.html.twig', [
            'complaint' => $complaint,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_complaint_show', methods: ['GET'])]
    public function show(Complaint $complaint): Response
    {
        return $this->render('complaint/show.html.twig', [
            'complaint' => $complaint,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_complaint_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Complaint $complaint, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ComplaintType::class, $complaint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_complaint_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('complaint/edit.html.twig', [
            'complaint' => $complaint,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_complaint_delete', methods: ['POST'])]
    public function delete(Request $request, Complaint $complaint, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$complaint->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($complaint);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_complaint_index', [], Response::HTTP_SEE_OTHER);
    }
}
