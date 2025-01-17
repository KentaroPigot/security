<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AccountController extends BaseController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        // $currentUser = $this->getUser();

        return $this->render('account/index.html.twig', []);
    }

    #[Route('/api/account', name: 'app_account')]
    public function accountApi()
    {
        $currentUser = $this->getUser();

        return $this->json(
            $currentUser,
            200,
            [],
            ['groups' => 'main']
        );
    }
}
