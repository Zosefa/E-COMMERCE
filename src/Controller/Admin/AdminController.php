<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\ModePaiement;
use App\Entity\Pays;
use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Vendeur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ClientCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ADMIN');
    }

    public function configureMenuItems(): iterable
    {
//        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Client', 'fas fa-shopping-cart', Client::class);
        yield MenuItem::linkToCrud('Vendeur', 'fas fa-users', Vendeur::class);
        yield MenuItem::linkToCrud('User', 'far fa-user', User::class);
        yield MenuItem::linkToCrud('Produit', 'fab fa-product-hunt', Produit::class);
        yield MenuItem::linkToCrud('ModePaiement', 'fab fa-product-hunt', ModePaiement::class);
        yield MenuItem::linkToCrud('Pays', 'fab fa-product-hunt', Pays::class);
    }
}
