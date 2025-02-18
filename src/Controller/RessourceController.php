<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\RessourceRepository;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ressource')]
final class RessourceController extends AbstractController{
    #[Route(name: 'app_ressource_index', methods: ['GET'])]
    public function index(RessourceRepository $ressourceRepository): Response
    {
        return $this->render('ressource/index.html.twig', [
            'ressources' => $ressourceRepository->findAll(),
        ]);
    }
    #[Route('/front/{idCourse}', name: 'app_ressource_index_front', methods: ['GET'], requirements: ['idCourse' => '\d+'])]
public function indexR(RessourceRepository $ressourceRepository, CourseRepository $courseRepository, int $idCourse): Response
{
    $course = $courseRepository->find($idCourse);

    if (!$course) {
        throw $this->createNotFoundException('Le cours demandé n\'existe pas.');
    }

    $ressources = $ressourceRepository->findBy(['course' => $course]);

    return $this->render('Front/index.html.twig', [
        'course' => $course,
        'ressources' => $ressources,
    ]);
}


    #[Route('/new', name: 'app_ressource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
    
            if ($file) {
                $uploadsDir = $this->getParameter('uploads_directory');
                $newFilename = uniqid().'.'.$file->guessExtension();
                $file->move($uploadsDir, $newFilename);
                $ressource->setFilePath('uploads/'.$newFilename);
            }
    
            $entityManager->persist($ressource);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_ressource_index');
        }
    
        return $this->render('ressource/new.html.twig', [
            'ressource' => $ressource,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{id}', name: 'app_ressource_show', methods: ['GET'])]
    public function show(Ressource $ressource): Response
    {
        return $this->render('ressource/show.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
    
            if ($file) {
                $uploadsDirectory = $this->getParameter('uploads_directory'); 
                $newFilename = uniqid().'.'.$file->guessExtension();
                $file->move($uploadsDirectory, $newFilename);
    
                // Delete old file if it exists
                if ($ressource->getFilePath()) {
                    $oldFilePath = $uploadsDirectory.'/'.$ressource->getFilePath();
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
    
                // Set new file path in entity
                $ressource->setFilePath('/uploads/'.$newFilename); // Store relative path
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('ressource/edit.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ressource->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ressource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
    }
}