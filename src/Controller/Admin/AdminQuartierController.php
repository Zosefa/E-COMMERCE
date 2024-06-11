<?php

namespace App\Controller\Admin;

use App\Entity\Quartier;
use App\Repository\QuartierRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/quartier', name: 'admin_app_admin_quartier')]
#[IsGranted('ROLE_ADMIN')]
class AdminQuartierController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(QuartierRepository $quartierRepository,VilleRepository $villeRepository): Response
    {
        $quartier = $quartierRepository->findAll();
        $user = $this->getUser()->getUserIdentifier();
        return $this->render('Admin/admin_quartier/index.html.twig', [
            'user' => $user,
            'quartier' => $quartier,
            'ville' => $villeRepository->findAll(),
        ]);
    }
    #[Route('/nouveau', name: '_new')]
    public function nouveau(Request $request,EntityManagerInterface $em,VilleRepository $villeRepository): Response
    {
        if($request->isMethod('POST')){
            $data = $request->request->get('quartier');
            $data1 = $request->request->get('ville');
            $ville = $villeRepository->find($data1);
            $quartier = new Quartier();
            $quartier
                ->setQuartier($data)
                ->setVille($ville);
            $em->persist($quartier);
            $em->flush($quartier);
            $this->addFlash('success','Quartier Ejouter');
            return $this->redirectToRoute('admin_app_admin_quartier');
        }
    }
    #[Route('/edit/{id}', name: '_edit')]
    public function edit($id,Request $request,EntityManagerInterface $em,VilleRepository $villeRepository,QuartierRepository $quartierRepository): Response
    {
        if($request->isMethod('POST')){

            $data = $request->request->get('quartier');
            $data1 = $request->request->get('ville');
            $quartier = $quartierRepository->find($id);
            $ville = $villeRepository->find($data1);
            $quartier
                ->setQuartier($data)
                ->setVille($ville);
            $em->flush($quartier);
            $this->addFlash('primary','Quartier Moidifer');
            return $this->redirectToRoute('admin_app_admin_quartier');
        }
    }
}
 