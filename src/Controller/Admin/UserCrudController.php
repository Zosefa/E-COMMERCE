<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;

class UserCrudController extends AbstractCrudController
{
    // use Trait\ReadOnlyInterface;
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //         ->add('username')
    //         ->add(ArrayFilter::new('roles'))
    //         // most of the times there is no need to define the
    //         // filter type because EasyAdmin can guess it automatically
    //         ->add(('Email'))
    //     ;
    // }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Username'),
            ArrayField::new('roles'),
            EmailField::new('Email'),
            BooleanField::new('active'),
        ];
    }
}
