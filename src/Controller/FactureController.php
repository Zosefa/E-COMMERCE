<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\VendeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/facture', name: 'app_facture')]
class FactureController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(CommandeRepository $commande,VendeurRepository $vendeurrepo): Response
    {   
        $commande->findAll();
        $user = $this->getUser();
        $vendeur = $vendeurrepo->find($vendeurrepo->getByUser($user));
        // $commandes = $commande->findBy(['Vendeur'=>$vendeurrepo->find($vendeurrepo->getByUser($user))]);
        $boolean = false;
        $commandes = $commande->getbyUserAndFacture($boolean,$vendeur);
        return $this->render('facture/index.html.twig', [
            'commande' => $commandes,
        ]);
    }

    #[Route('/effectuer', name: '_facturer')]
    public function facture(CommandeRepository $commande,VendeurRepository $vendeurrepo): Response
    {   
        $user = $this->getUser();
        $vendeur = $vendeurrepo->find($vendeurrepo->getByUser($user));
        $commandes = $commande->findBy(['Vendeur'=>$vendeurrepo->find($vendeurrepo->getByUser($user))]);
        $boolean = true;
        $commandes = $commande->getbyUserAndFacture($boolean,$vendeur);
        return $this->render('facture/facturer.html.twig', [
            'commande' => $commandes,
        ]);
    }
}
