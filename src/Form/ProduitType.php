<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Vendeur;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Produit',TextType::class)
            ->add('Description',TextareaType::class)
            ->add('Prix',IntegerType::class)
            ->add('QteDispo',IntegerType::class,[
                'label' => 'Quantite Disponible' 
            ])
            ->add('ImageFile',FileType::class,[
                'label' => 'Image'
            ])
            ->add('Categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'Categorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
