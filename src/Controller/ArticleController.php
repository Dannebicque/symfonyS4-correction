<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/article/new', name: 'app_article_new')]
    public function new(
        Request $request,
        ArticleRepository $articleRepository
    ): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article, [
            'codePostal' => '10000',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_article_new');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}/edit', name: 'app_article_edit')]
    public function edit(
        EntityManagerInterface $entityManager,
        Request $request,
        Article $article,
        ArticleRepository $articleRepository
    ): Response {
        $form = $this->createForm(ArticleType::class, $article, [
            'codePostal' => '10000',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_edit', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
