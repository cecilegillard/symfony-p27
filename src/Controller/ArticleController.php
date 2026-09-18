<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => ($this->getUser() ) ?  $this->getUser()->getNom() : "??",
        ]);
    }

    #[Route('/articleRandom', name: 'app_article_random')]
    public function random(): Response
    {
        $number = random_int(0, 100);

        return $this->render('article/random.html.twig', [
            'number' => $number,
        ]);
    }


    #[Route('/addArticle', name: 'app_article_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add(EntityManagerInterface $entityManager ): Response
    {
        $article = new Article();

        $article->setTitre('Mon article');
        $article->setContenu('Mon contenu');
        $article->setAuteur($this->getUser());

        $entityManager->persist($article);

        $entityManager->flush(); // permet d'executer les requêtes nécessaires


        return new Response('Ajout article effectué');
    }
}
