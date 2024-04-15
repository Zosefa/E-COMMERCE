<?php

namespace App\Controller\Admin;

use App\Entity\ModePaiement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ModePaiementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ModePaiement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('CodeMP'),
            TextField::new('ModeP'),
        ];
    }
}
