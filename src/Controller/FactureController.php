<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Repository\CommandeRepository;
use App\Repository\FactureRepository;
use App\Repository\VendeurRepository;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/facture', name: 'app_facture')]
class FactureController extends AbstractController
{

    #[Route('/', name: '_index')]
    public function index(CommandeRepository $commande,VendeurRepository $vendeurrepo,FactureRepository $factureRepository): Response
    {   
        $commande->findAll();
        $user = $this->getUser();
        $vendeur = $vendeurrepo->find($vendeurrepo->getByUser($user));
        $boolean = false;
        $facture = $factureRepository->selectbyVendeur($vendeur,$boolean);
        return $this->render('facture/index.html.twig', [
            'commande' => $facture,
        ]);
    }

    #[Route('/effectuer', name: '_facturer')]
    public function facture(CommandeRepository $commande,VendeurRepository $vendeurrepo,FactureRepository $factureRepository): Response
    {   
        $commande->findAll();
        $user = $this->getUser();
        $vendeur = $vendeurrepo->find($vendeurrepo->getByUser($user));
        $boolean = true;
        $facture = $factureRepository->selectbyVendeur($vendeur,$boolean);
        return $this->render('facture/facturer.html.twig', [
            'commande' => $facture,
        ]);
    }

    #[Route('/generation/{id}', name: '_generer')]
    public function generer(Facture $facture,CommandeRepository $commande,EntityManagerInterface $em): Response
    { 
        $resultat = $commande->selectAll($facture);
        foreach ($resultat as $value) {
            $singleResult = $value;
        }

        $facture->setFacturer(true);
        $em->flush();
        return $this->render('facture/facture.html.twig', [
            'result' => $resultat,
            'info' => $singleResult,
            'facture' => $facture
        ]);
    }

    #[Route('/voir/{id}', name: '_voire')]
    public function voir(Facture $facture,CommandeRepository $commande,EntityManagerInterface $em): Response
    { 
        $resultat = $commande->selectAll($facture);
        foreach ($resultat as $value) {
            $singleResult = $value;
        }
        return $this->render('facture/voir.html.twig', [
            'result' => $resultat,
            'info' => $singleResult,
            'facture' => $facture
        ]);
    }
}
