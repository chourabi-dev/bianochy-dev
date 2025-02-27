<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubCategory::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setLabel('N°'),
            TextField::new('label')->setColumns(6)->setLabel("product.title"), 
            AssociationField::new('category')->setColumns(6)->setLabel("product.category")->setFormTypeOption('choice_label', 'label'), 
            ImageField::new('icon')
            ->setColumns(12)
            ->setBasePath('/uploads/icons') // Folder where the images will be stored
            ->setUploadDir('public/uploads/icons') // Directory for uploaded images
            ->setRequired(false) // Make this field optional
            ->setUploadedFileNamePattern('[randomhash].[extension]') // Unique filename pattern
            ->setLabel('Icon') // Custom label for the field

        ];
    }
    
}
