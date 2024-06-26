<?php

namespace App\Controller;

use App\Repository\ModePaiementRepository;
use App\Repository\ProduitRepository;
use App\Services\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/panier', name: 'app_cart')]
    public function index(SessionInterface $session,ProduitRepository $produitRepository,ModePaiementRepository $moderepository,)
    {
        $panier = $session->get('panier',[]);
        $boutique = $session->get('boutique','');
        $panierWithData = [];
        foreach ($panier as $id => $quantite) {
            $panierWithData[] = [
                'produit' =>$produitRepository->find($id),
                'quantiter' => $quantite
            ]; 
        } 
        $total = 0;
        if(!empty($panierWithData)){
            foreach ($panierWithData as $key) {
                $totalProduit = $key['produit']->getPrix() * $key['quantiter'];
                $total +=$totalProduit;
            }
        }else{
            $total = 0;
        }
        return $this->render('cart/panier.html.twig', [
            'boutique' => $boutique,
            'paniers' => $panierWithData,
            'total' => $total,
            'ModeMp' => $moderepository->findAll(),
        ]);
    }

    #[Route('/panier/add/{id}/{boutique}', name: 'app_cart_add')]
    public function add($id,$boutique,SessionInterface $session,Request $request)
    { 
        $panier = $session->get('panier',[]);
            if($request->isMethod('post')){
                $qte = $request->request->get('qte');
                if(!empty($panier[$id])){
                    $panier[$id] += $qte;
                }else{
                    $panier[$id]=$qte;
                }
            }
            // $panier[$id] = $qte;
            $session->set('panier',$panier);         
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/panier/addOne/{id}', name: 'app_cart_addOne')]
    public function addOne($id,SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
            if(!empty($panier[$id])){
                $panier[$id]++;
            }
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/panier/removeOne/{id}', name: 'app_cart_removeOne')]
    public function removeOne($id,SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
            if(!empty($panier[$id])){
                $panier[$id]--;
            }
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('panier/remove/{id}' , name:'app_cart_remove')]
    public function remove($id,SessionInterface $session){
        $panier = $session->get('panier', []);
        // dd($panier);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_cart');
    }
}
