<?php

namespace App\Controller;

use App\Repository\PaysRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    #[IsGranted('ROLE_CLIENT')]
    public function index(ProduitRepository $produit,PaysRepository $pays): Response
    {
        $produits = $produit->findAll();
        $payss = $pays->findAll();
        return $this->render('boutique/Boutique.html.twig', [
            'produits' => $produits,
            'pays' => $payss
        ]);
    }
}
