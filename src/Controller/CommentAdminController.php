<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN_COMMENT')]
class CommentAdminController extends AbstractController
{
    // #[Route('/admin/comment', name: 'comment_admin')]
    // public function index(): Response
    // {
    //     return $this->render('comment_admin/index.html.twig', [
    //         'controller_name' => 'CommentAdminController',
    //     ]);
    // }

    #[Route('/admin/comment', name: 'comment_admin')]
    // #[IsGranted('ROLE_ADMIN')]
    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $q = $request->query->get('q');

        $queryBuilder = $repository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('comment_admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
