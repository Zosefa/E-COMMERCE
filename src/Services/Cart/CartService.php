<?php
namespace App\Services\Cart;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

    class CartService{
        protected $repositoryProduit;
        protected $session;
        public function __construct(ProduitRepository $produitRepository,SessionInterface $session)
        {
            $this->repositoryProduit = $produitRepository;
            $this->session = $session;     
        }
        public function Add(int $id){
            // $panier = $this->session->get('panier',[]);
            // if(!empty($panier[$id])){
            //     $panier[$id]++;
            // }else{
            //     $panier[$id] = 1;
            // }
            // $this->session->set('panier',$panier);
        }
        public function remove(int $id){

        }
        // public function GetFull(): array
        // {

        // }
        // public function GetTotal(): float
        // {

        // }
    }