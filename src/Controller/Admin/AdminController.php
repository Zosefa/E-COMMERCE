<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\ModePaiement;
use App\Entity\Pays;
use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Vendeur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    // #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ClientCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ADMINISTRATION');
    }
    
    // public function configureUserMenu(UserInterface $user): UserMenu
    // {
    //     return parent::configureUserMenu($user)
    //         // use the given $user object to get the user name
    //         ->setName($user->getUserIdentifier())
    //         // use this method if you don't want to display the name of the user
    //         ->displayUserName(false)

    //         // you can return an URL with the avatar image
    //         // ->setAvatarUrl('https://...')
    //         // ->setAvatarUrl($user->getProfileImageUrl())
    //         // use this method if you don't want to display the user image
    //         // ->displayUserAvatar(false)
    //         // you can also pass an email address to use gravatar's service
    //         // ->setGravatarEmail($user->getMainEmailAddress())

    //         // you can use any type of menu item, except submenus
    //         ->addMenuItems([
    //             MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
    //             MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
    //             MenuItem::section(),
    //             MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
    //         ]);
    // }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Acteur', 'fas fa-users')->setSubItems([
            MenuItem::linkToCrud('Vendeur', 'fas fa-users', Vendeur::class),
            MenuItem::linkToCrud('Clients', 'fas fa-shopping-cart', Client::class),
            MenuItem::linkToCrud('User', 'far fa-user', User::class),
        ]);

        yield MenuItem::subMenu('Marchandise', 'fab fa-product-hunt')->setSubItems([
            MenuItem::linkToCrud('Produit', 'fab fa-product-hunt', Produit::class),
        ]);

        yield MenuItem::subMenu('Facture', 'fab fa-product-hunt')->setSubItems([
            MenuItem::linkToCrud('ModePaiement', 'fab fa-product-hunt', ModePaiement::class),
            MenuItem::linkToCrud('Commande', 'fab fa-product-hunt', Commande::class),
        ]);
    }
}
