<?php

namespace App\Controller\Admin;

use App\Repository\ProduitRepository;
use App\Repository\VendeurRepository;
use App\Service\Cryptage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/boutique', name: 'admin_app_admin_boutique')]
#[IsGranted('ROLE_ADMIN')]
class AdminBoutiqueController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(VendeurRepository $vendeurRepository): Response
    {
        $vendeur = $vendeurRepository->findAll();
        $user = $this->getUser()->getUserIdentifier();
        return $this->render('Admin/admin_boutique/index.html.twig', [
            'user' => $user,
            'vendeur' => $vendeur,
        ]);
    }
    #[Route('/cryptage/{id}', name: '_cryptage')]
    public function cryptage($id,Cryptage $cryptage){
        $crypte=$cryptage->encrypt($id);
        return $this->redirectToRoute('admin_app_admin_boutique_produit',['id' => $crypte]);
    }

    #[Route('/produit/{id}', name: '_produit')]
    public function produit($id,VendeurRepository $vendeurRepository,ProduitRepository $produitRepository,Cryptage $cryptage): Response
    {
        $idvendeur = $cryptage->decrypt($id);
        $vendeur = $vendeurRepository->find($idvendeur);
        $produit = $produitRepository->findbyVendeur($vendeur);
        $user = $this->getUser()->getUserIdentifier();
        return $this->render('Admin/admin_boutique/produit.html.twig', [
            'user' => $user,
            'produit' => $produit,
            'vendeur' => $vendeur,
        ]);
    }
}
