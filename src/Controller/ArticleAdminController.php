<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleAdminController extends AbstractController
{
    #[Route('/admin/article/new', name: 'app_admin_article')]
    public function index(): Response
    {
        // return $this->render('article_admin/index.html.twig', [
        //     'controller_name' => 'ArticleAdminController',
        // ]);
        die('todo');

        return new Response(sprintf(
            'Hiya! New Article id: #%d slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}
