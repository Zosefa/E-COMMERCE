<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/inscription', name: 'inscription')]
class InscriptionController extends AbstractController
{
    #[Route('/', name: '.admin')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();
            $confirm = $form->get('ConfirmPass')->getData();
            if($password === $confirm){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setConfirm(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('ConfirmPass')->getData()
                    )
                );
                $user->setRoles(['ROLE_ADMIN']);
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('admin');
            }else{
                $this->addFlash('danger',"Le Mot de passe etre identique");
            }
        }
        return $this->render('inscription/inscription.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
