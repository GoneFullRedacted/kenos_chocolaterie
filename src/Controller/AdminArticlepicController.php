<?php

namespace App\Controller;

use App\Entity\Articlepic;
use App\Form\ArticlepicType;
use App\Repository\ArticlepicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/articlepic')]
final class AdminArticlepicController extends AbstractController
{
    #[Route(name: 'app_admin_articlepic_index', methods: ['GET'])]
    public function index(ArticlepicRepository $articlepicRepository): Response
    {
        return $this->render('admin_articlepic/index.html.twig', [
            'articlepics' => $articlepicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_articlepic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articlepic = new Articlepic();
        $form = $this->createForm(ArticlepicType::class, $articlepic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($articlepic);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_articlepic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_articlepic/new.html.twig', [
            'articlepic' => $articlepic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_articlepic_show', methods: ['GET'])]
    public function show(Articlepic $articlepic): Response
    {
        return $this->render('admin_articlepic/show.html.twig', [
            'articlepic' => $articlepic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_articlepic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Articlepic $articlepic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticlepicType::class, $articlepic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_articlepic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_articlepic/edit.html.twig', [
            'articlepic' => $articlepic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_articlepic_delete', methods: ['POST'])]
    public function delete(Request $request, Articlepic $articlepic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articlepic->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($articlepic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_articlepic_index', [], Response::HTTP_SEE_OTHER);
    }
}
