<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Facture;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\FactureRepository;
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
    #[Route('/commande/valider/{total}', name: 'app_commande_valider')]
    public function valider($total,Request $request, SessionInterface $session,ClientRepository $clientRepository,ProduitRepository $produitRepository,ModePaiementRepository $ModePrepository,EntityManagerInterface $em,VendeurRepository $vendeurrepo,CommandeRepository $commandeRepository,FactureRepository $factureRepository): Response
    {
        if($request->isMethod('POST')){
            $n = 0;
            $allfacture = $factureRepository->findAll();
            $i = 1;
            $date = new \DateTime();
            $annee = $date->format('y');
            if($allfacture == []){
                $numero = '000'.$i.'/'.$annee;
            }else{
                foreach ($allfacture as $key => $value) {
                    $nb = $key;
                }
                if($nb == 0){
                    $i++;
                }else{
                    $nb ++;
                    $i += $nb;
                }
                if($i <= 9){
                    $numero = '000'.$i.'/'.$annee;
                }else if($i <= 99){
                    $numero = '00'.$i.'/'.$annee;
                }else if($i <= 999){
                    $numero = '0'.$i.'/'.$annee;
                }else{
                    $numero = $i.'/'.$annee;
                }
            }
            $facture = new Facture(); 
            $facture
                ->setNumeroFacture($numero)
                ->setDateFacture(new \DateTime('now'))
                ->setMontantTotal($total)
                ->setFacturer(false);
            $em->persist($facture);
            $em->flush();  
            $allCommande = [];
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
            $date = new \DateTime('now');
            if($produit->getQteDispo() >= $quantite){
                $n = $n + 1;
                $newQte = $produit->getQteDispo() - $quantite;
                $produit->setQteDispo($newQte);
                $prixp=$produit->getPrix();
                $commande
                     ->setQteC($quantite)
                     ->setDateCommande($date)
                     ->setClient($client)
                     ->setProduit($produit)
                     ->setModeP($ModeP)
                     ->setMontant($quantite * $prixp)
                     ->setVendeur($vendeurvalue);
            
                $em->persist($commande);
                $em->flush();

                $commandes = $commandeRepository->findAll();
                foreach ($commandes as $value) {
                    $thecommande = $value;
                }
                $AllFacture = $factureRepository->findAll();
                foreach ($AllFacture as $value) {
                    $TheFacture =  $value;
                }
                $TheFacture->addCommande($thecommande);
                $em->flush();
            }else{
                $panier = [];
                $session->set('panier',$panier);
                $this->addFlash('danger',"Commande Annuler car le stock du produit '".$produit->getProduit()."' est insuffisant");
                $lastCommande = $commandeRepository->getDernierCommande($n);
                foreach ($lastCommande as $value) {
                    $CommandeLast = $value;
                    $qteproduit = $CommandeLast->getQteC();
                    $produit = $CommandeLast->getProduit();
                    $qteproduitdispo = $produit->getQteDispo();
                    $newQte = $qteproduitdispo + $qteproduit;
                    $produit->setQteDispo($newQte);
                    $em->remove($CommandeLast);
                    $em->flush();
                }
                $lastFacture = $factureRepository->getLastFacture();
                foreach ($lastFacture as  $value) {
                    $factureLast = $value;
                    $em->remove($factureLast);
                    $em->flush();
                }
                return $this->redirectToRoute('boutique_index');
            }       
            // $addCommande = [];
            // foreach ($allCommande as $value) {
            //     $addCommande = [
            //         $value
            //     ];
            // }
            // dd($addCommande);
              
        }
        
        $panier = [];
        $session->set('panier',$panier);
        $this->addFlash('success',"Commande Envoyer");
        return $this->redirectToRoute('boutique_index');
        }
    }
}
