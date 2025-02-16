<?php

namespace App\Controller;

use App\Entity\ComplaintResponse;
use App\Form\ComplaintResponseType;
use App\Repository\ComplaintResponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/complaint/response')]
final class ComplaintResponseController extends AbstractController
{
    #[Route(name: 'app_complaint_response_index', methods: ['GET'])]
    public function index(ComplaintResponseRepository $complaintResponseRepository): Response
    {
        return $this->render('complaint_response/index.html.twig', [
            'complaint_responses' => $complaintResponseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_complaint_response_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $complaintResponse = new ComplaintResponse();
        $form = $this->createForm(ComplaintResponseType::class, $complaintResponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($complaintResponse);
            $entityManager->flush();

            return $this->redirectToRoute('app_complaint_response_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('complaint_response/new.html.twig', [
            'complaint_response' => $complaintResponse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_complaint_response_show', methods: ['GET'])]
    public function show(ComplaintResponse $complaintResponse): Response
    {
        return $this->render('complaint_response/show.html.twig', [
            'complaint_response' => $complaintResponse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_complaint_response_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ComplaintResponse $complaintResponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ComplaintResponseType::class, $complaintResponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_complaint_response_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('complaint_response/edit.html.twig', [
            'complaint_response' => $complaintResponse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_complaint_response_delete', methods: ['POST'])]
    public function delete(Request $request, ComplaintResponse $complaintResponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$complaintResponse->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($complaintResponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_complaint_response_index', [], Response::HTTP_SEE_OTHER);
    }
}
