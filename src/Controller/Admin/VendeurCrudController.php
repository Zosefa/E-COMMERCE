<?php

namespace App\Controller\Admin;

use App\Entity\Vendeur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VendeurCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return Vendeur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Vendeur'),
            TextField::new('Siege'),
            TextField::new('TelV'),
            TextField::new('Pays'),
            TextField::new('users'),
        ];
    }
}
