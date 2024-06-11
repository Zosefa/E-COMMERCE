<?php

namespace App\Controller;

use App\Entity\Vendeur;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\VendeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(ProduitRepository $produitRepository,ClientRepository $clientRepository,VendeurRepository $vendeurRepository, CommandeRepository $commandeRepository): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $date = new \DateTime();
        return $this->render('dashboard/dashboard.html.twig', [
            'user' => $user,
            'produit' => $produitRepository->count(),
            'client' => $clientRepository->count(),
            'vendeur' => $vendeurRepository->count(),
            'commande' => $commandeRepository->count(),
        ]);
    }
}
