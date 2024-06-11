<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/user', name: 'admin_app_admin_user')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(UserRepository $userRepository): Response
    {
        $usersActif = $userRepository->UserActif();
        $usersNonActif = $userRepository->UserNonActif();
        $usersDescativer = $userRepository->Descativer();
        $user = $this->getUser()->getUserIdentifier();
        return $this->render('Admin/admin_user/index.html.twig', [
            'user' => $user,
            'usersActive' => $usersActif,
            'usersNonActive' => $usersNonActif,
            'Descativer' => $usersDescativer,
        ]); 
    }

    #[Route('/toggle-active/{id}', name: '_toggle', methods: ['POST'])]
    public function toggleActive(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $user
            ->setActive(!$user->isActive())
            ->setDescativer(!$user->isDescativer());
        $entityManager->flush();

        return new JsonResponse(['status' => 'success', 'active' => $user->isActive()]);
    }
}
   