<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/article')]
final class AdminArticleController extends AbstractController
{
    #[Route(name: 'app_admin_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin_article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        // Traiter les images des articles
        foreach ($form->get('articlepics') as $articlepicform) {
            $articlePicEntity = $articlepicform->getData();

            if ($articlepicform->has('isDeleted') && $articlepicform->get('isDeleted')->getData()) {
                $article->removeArticlepic($articlePicEntity);
                
                continue; 
            }            
            // Récupérer le fichier uploadé
            $imageFile = $articlepicform->get('picFile')->getData(); // UploadedFile ou null
            
            if ($imageFile) {
                // Upload dans le répertoire 'articles'
                $newFilename = $fileUploader->upload($imageFile, $article->getAtitle(), 'articles');
                
                // Sauvegarder le nom du fichier en BDD
                $articlepicform->getData()->setPic($newFilename);
            }
        }

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
    }

        return $this->render('admin_article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('admin_article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FileUploader $fileUploader, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        // Traiter les images des articles
        foreach ($form->get('articlepics') as $articlepicform) {

            $articlePicEntity = $articlepicform->getData();

            if ($articlepicform->has('isDeleted') && $articlepicform->get('isDeleted')->getData()) {
                
                // Supprimer l'image physique si elle existe
                $oldFilename = $articlePicEntity->getPic(); 
                if ($oldFilename) {
                        $fileUploader->delete($oldFilename, 'articles');
                }

                $article->removeArticlepic($articlePicEntity);
                
                $entityManager->remove($articlePicEntity);

                // Passer à l'itération suivante
                continue; 
            }
            // Récupérer le nouveau fichier uploadé
            $newImageFile = $articlepicform->get("picFile")->getData(); // UploadedFile ou null

            dump($newImageFile);

            if ($newImageFile) {
                // Supprimer l'ancienne image si elle existe
                $oldFilename = $articlepicform->getData()->getPic(); // string depuis la BDD
                if ($oldFilename) {
                    $fileUploader->delete($oldFilename, 'articles');
                }
                
                // Upload la nouvelle image
                $newFilename = $fileUploader->upload($newImageFile, $article->getAtitle(), 'articles');
                $articlepicform->getData()->setPic($newFilename); // string
            }
        }

        $entityManager->persist($article);
        $entityManager->flush();


        return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
    }

        return $this->render('admin_article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
