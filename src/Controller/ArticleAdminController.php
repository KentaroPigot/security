<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN_CONTROLLER')]
class ArticleAdminController extends AbstractController
{
    #[Route('/admin/article/new', name: 'admin_article_new')]
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
