<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\ClientRepository;
use App\Repository\ModePaiementRepository;
use App\Repository\ProduitRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande/valider', name: 'app_commande_valider')]
    public function valider(Request $request, SessionInterface $session,ClientRepository $clientRepository,ProduitRepository $produitRepository,ModePaiementRepository $ModePrepository,EntityManagerInterface $em,VendeurRepository $vendeurrepo): Response
    {
        if($request->isMethod('POST')){
            $idModeP = $request->request->get('modep');
            $panier = $session->get('panier',[]);
        foreach ($panier as $idproduit => $quantite) {
            $the_vendeur = $session->get('boutique','');
            $vendeur = $vendeurrepo->findBy(['Vendeur'=>$the_vendeur]);
            foreach ($vendeur as $value) {
                $vendeurvalue = $value;
            }
            
            $commande = new Commande();

            $user=$this->getUser();

            $idClient = $clientRepository->getByUser($user);
            $client = $clientRepository->find($idClient);

            $produit = $produitRepository->find($idproduit);

            $ModeP = $ModePrepository->find($idModeP);
            $date = new \DateTime();
            $commande
                     ->setQteC($quantite)
                     ->setDateCommande($date)
                     ->setClient($client)
                     ->setProduit($produit)
                     ->setModeP($ModeP)
                     ->setFacture(false)
                     ->setVendeur($vendeurvalue);
            
            $em->persist($commande);
            $em->flush();
        }
        $panier = [];
        $session->set('panier',$panier);
        $this->addFlash('success',"Commande Envoyer");
        return $this->redirectToRoute('boutique_index');
        }
    }
}
