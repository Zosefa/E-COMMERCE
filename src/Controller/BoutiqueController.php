<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\VendeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/boutique', name: 'boutique')]
#[IsGranted('ROLE_CLIENT')]
class BoutiqueController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(ProduitRepository $produit,VendeurRepository $vendeur,SessionInterface $session): Response
    {
        $boutique = '';
        $panier = [];
        $session->get('panier',[]);
        $session->set('panier',$panier);
        $session->get('boutique','');
        $session->set('boutique',$boutique);
        $vendeurs = $vendeur->findAll();
        $produits = $produit->findAll();
        return $this->render('boutique/Boutique.html.twig', [
            'produits' => $produits,
            'vendeurs' => $vendeurs,
        ]);
    }

    #[Route('/{boutique}',name: '_liste')]
    public function liste($boutique ,ProduitRepository $repositoryproduit,VendeurRepository $vendeurrepository,SessionInterface $session){
        $vendeur = $vendeurrepository->findBy(['Vendeur' => $boutique]);
        $boutiqueSession = $session->get('boutique','');
        $boutiqueSession = $session->set('boutique',$boutique);
        $produit = $repositoryproduit->findByvendeur($vendeur);
        return $this->render('boutique/liste.html.twig',[
            'produits' => $produit,
            'boutiques' => $boutique
        ]);
    }
}
