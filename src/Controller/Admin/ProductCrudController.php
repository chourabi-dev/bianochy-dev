<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setLabel('N°'),
            
            TextField::new('label')->setColumns(12)->setLabel("Titre"),
            TextField::new('subtitle')->setColumns(12)->setLabel("Sous-titre"), 
            MoneyField::new('price')->setColumns(12)->setLabel("Prix")->setCurrency('TND'),
            BooleanField::new('enStock')->setColumns(12)->setLabel("En stock"),

            
            TextEditorField::new('descreption')->setColumns(12)->setLabel("Description")->hideOnIndex(),
            TextEditorField::new('features')->setColumns(12)->setLabel("Caracteristiques")->hideOnIndex(),
            TextEditorField::new('howToUse')->setColumns(12)->setLabel("Nos conseils d'application")->hideOnIndex(),
            TextEditorField::new('delivery')->setColumns(12)->setLabel("Livraison")->hideOnIndex(),
            
             
            
            
            
            // category many to one entity feild
            AssociationField::new('category')->setColumns(12)->setLabel("Catégorie")->setFormTypeOption('choice_label', 'label'), 
            DateTimeField::new('createdAt')->setLabel("Date d'ajout")->hideOnForm()
        ];
    }


    public function new(AdminContext $context)
    { 
        return parent::new($context);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Product && $entityInstance->getCreatedAt() === null) {
            $entityInstance->setCreatedAt(new \DateTime());
        }
        $this->addFlash(
            'success',
            'Produit enregistré avec succès'
         );
        parent::persistEntity($entityManager, $entityInstance);

        
     }
    
}
