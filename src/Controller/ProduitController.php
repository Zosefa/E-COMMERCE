<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\UpdateProduitType;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use App\Repository\VendeurRepository;
use App\Service\Cryptage;
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
    // private string $chipper = 'aes-256-cbc';
    // private string $secretKey = '$_#&';
    #[Route('/',name: '_liste')]
    public function liste(ProduitRepository $produitRepository,VendeurRepository $vendeurrepository,Request $request): Response
    {
        $maxPage=0;
        $page=0;
        $recherche = $request->request->get('rech');
        $user = $this->getUser();
        $idvendeur = $vendeurrepository->getByUser($user);
        $vendeur = $vendeurrepository->find($idvendeur);
        if(isset($recherche)){
            $input = $request->request->get('recherche');
            $produit = $produitRepository->recherche($input,$vendeur);
        }else{
            $page = $request->query->getInt('page',1);
            $limit = 3;
            $produit = $produitRepository->paginator($page,$limit,$vendeur);
            $maxPage = ceil($produit->getTotalItemCount() / $limit);
        }
        return $this->render('produit/index.html.twig',[
            'produit' => $produit,
            'maxpage' => $maxPage,
            'page' => $page
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

    #[Route('/cryptage/{id}', name: '_cryptage')]
    public function cryptage($id,Cryptage $cryptage){
        $crypte = $cryptage->encrypt($id);
        return $this->redirectToRoute('app_produit_update',['id' => $crypte]);
    }


    #[Route('/update/{id}', name: '_update')]
    public function update($id, ProduitRepository $produitrepo, Request $request, EntityManagerInterface $em,Cryptage $cryptage)
    {
        $decrypt = $cryptage->decrypt($id);
        $produit = $produitrepo->find($decrypt);
        $form = $this->createForm(UpdateProduitType::class,$produit);
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

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(Produit $produit, Request $request, EntityManagerInterface $em)
    {
        $em->remove($produit);
        $em->flush();
        $this->addflash('danger','Produit Supprimer');
        return $this->redirectToRoute('app_produit_liste');
    }

    #[Route('/stock/{id}', name: '_stock')]
    public function stock(Produit $produit, Request $request, EntityManagerInterface $em)
    {
        if($request->isMethod('POST')){
            $qte = $produit->getQteDispo();
            $newstock = $qte + $request->request->get('stock');
            $produit->setQteDispo($newstock);
            $em->flush();
            $this->addflash('success','Stock Ajouter');
            return $this->redirectToRoute('app_produit_liste');
        } 
    }
}
