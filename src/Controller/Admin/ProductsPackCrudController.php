<?php

namespace App\Controller\Admin;

use App\Entity\ProductsPack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductsPackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductsPack::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            /*
            
    #[ORM\Column(length: 1000)]
    private ?string $title = null;

 

 
            */

            IdField::new('id')->setLabel('N°')->hideOnForm(), 
            TextField::new('title')->setColumns(12)->setLabel("product.title"),
            AssociationField::new('products')->setColumns(12)->setLabel("product.products_list")->hideOnIndex(),
            NumberField::new('price')->setColumns(12)->setLabel("product.price"),

            
            ImageField::new('photo')
                ->setColumns(12)
                ->setBasePath('/uploads/packs') 
                ->setUploadDir('public/uploads/packs') 
                ->setRequired(false) 
                ->setUploadedFileNamePattern('[randomhash].[extension]') 
                ->setLabel('photo'),

            
            TextEditorField::new('descreption')->setColumns(12)->setLabel("product.description")->hideOnIndex(),

            
              
        ];
    }
    
}
