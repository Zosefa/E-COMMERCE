<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/produit', name: 'app_produit')]
#[IsGranted('ROLE_VENDEUR')]
class ProduitController extends AbstractController
{
    #[Route('/',name: '_liste')]
    public function liste(ProduitRepository $produitRepository,VendeurRepository $vendeurrepository): Response
    {
        $user = $this->getUser();
        $idvendeur = $vendeurrepository->getByUser($user);
        $vendeur = $vendeurrepository->find($idvendeur);
        $produit = $produitRepository->findBy(['Vendeur'=>$vendeur]);
        return $this->render('produit/index.html.twig',[
            'produit' => $produit
        ]);
    }

    #[Route('/insert', name: '_insert', methods:['GET','POST'])]
    public function insert(Request $request, EntityManagerInterface $em, VendeurRepository $vendeurrepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        $user = $this->getUser();
        $idvendeur = $vendeurrepository->getByUser($user);
        $vendeur = $vendeurrepository->find($idvendeur);
        if($form->isSubmitted() && $form->isValid()){
            $produit->setVendeur($vendeur);
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success','PRODUIT ENREGISTRER');
            return $this->redirectToRoute('app_produit_liste');
        }
        return $this->render('produit/insert.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/update/{id}', name: '_update')]
    public function update(Produit $produit, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addflash('success','Produit Modifier');
            return $this->redirectToRoute('app_produit_liste');
        }
        return $this->render('produit/update.html.twig', [
            'form' => $form,
            'Produit' => $produit
        ]);
    }
}
