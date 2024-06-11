<?php

namespace App\Controller\Admin;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/client', name: 'admin_app_admin_client')]
#[IsGranted('ROLE_ADMIN')]
class AdminClientController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->findAll();
        $user = $this->getUser()->getUserIdentifier();
        return $this->render('Admin/admin_client/index.html.twig', [
            'user' => $user,
            'client' => $client,
        ]);
    }
}
