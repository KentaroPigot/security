<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
// use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    /**
     * Currently unused: just showing a controller with a constructor!
     */
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    #[Route('/', name: 'app_homepage')]
    public function homepage(ArticleRepository $repository): Response
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/news/{slug}', name: 'article_show')]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route("/news/{slug}/heart", name: "article_toggle_heart", methods: ["POST"])]
    // public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();

        $logger->info('Article is being hearted!');

        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}
