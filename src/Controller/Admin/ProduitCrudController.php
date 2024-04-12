<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Produit'),
            TextEditorField::new('description'),
            IntegerField::new('Prix'),
            TextField::new('ImageFile')->setFormType(VichImageType::class)->onlyWhenUpdating(),
            ImageField::new('Photo')->setBasePath('images/produit')->onlyOnIndex(),
            // TextField::new('Vendeur'),
        ];
    }
}
