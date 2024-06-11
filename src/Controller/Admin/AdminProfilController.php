<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/profil', name: 'app_admin_profil')]
#[IsGranted('ROLE_ADMIN')]
class AdminProfilController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {   
        $user = $this->getUser()->getUserIdentifier();
        $profil = $this->getUser();
        return $this->render('Admin/admin_profil/index.html.twig', [
            'user' => $user,
            'profil' => $profil,
        ]);
    }

    #[Route('/edit/{id}', name: '_edit')]
    public function edit(User $user,Request $request,UserPasswordHasherInterface $hash,EntityManagerInterface $em): Response
    {   
        if($request->isMethod('POST')){
            $pass = $request->request->get('password');
            if($pass != ''){
                $user
                    ->setUsername($request->request->get('username'))
                    ->setEmail($request->request->get('mail'))
                    ->setPassword($hash->hashPassword($user,$pass));
                $em->flush();
                return $this->redirectToRoute('dashboard');
            }else{
                $user
                    ->setUsername($request->request->get('username'))
                    ->setEmail($request->request->get('mail'));
                $em->flush();
                return $this->redirectToRoute('dashboard');
            }
        }
    }
}
