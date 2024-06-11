<?php

namespace App\Controller\Admin;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/ville', name: 'admin_app_admin_ville')]
#[IsGranted('ROLE_ADMIN')]
class AdminVilleController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(VilleRepository $villeRepository): Response
    {
        $ville = $villeRepository->findAll();
        $user = $this->getUser()->getUserIdentifier();
        return $this->render('Admin/admin_ville/index.html.twig', [
            'user' => $user,
            'ville' => $ville,
        ]);
    }
    #[Route('/nouveau', name: '_new')]
    public function nouveau(Request $request,EntityManagerInterface $em): Response
    {
        if($request->isMethod('POST')){
            $data = $request->request->get('ville');
            $ville = new Ville();
            $ville->setVille($data);
            $em->persist($ville);
            $em->flush($ville);
            $this->addFlash('success','Ville Ejouter');
            return $this->redirectToRoute('admin_app_admin_ville');
        }
    }
    #[Route('/edit/{id}', name: '_edit')]
    public function edit($id,Request $request,EntityManagerInterface $em,VilleRepository $villeRepository): Response
    {
        if($request->isMethod('POST')){

            $data = $request->request->get('ville');
            $ville = $villeRepository->find($id);
            $ville->setVille($data);
            $em->flush($ville);
            $this->addFlash('primary','Ville Moidifer');
            return $this->redirectToRoute('admin_app_admin_ville');
        }
    }
}
