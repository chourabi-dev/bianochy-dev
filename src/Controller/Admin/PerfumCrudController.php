<?php

namespace App\Controller\Admin;

use App\Entity\Perfum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PerfumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Perfum::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setLabel('N°'), 
            TextField::new('label')->setColumns(6)->setLabel('Titre')->setRequired(true),
            ImageField::new('photo')
                ->setColumns(6)
                ->setBasePath('/uploads/icons') // Folder where the images will be stored
                ->setUploadDir('public/uploads/icons') // Directory for uploaded images
                ->setRequired(true) // Make this field optional
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Unique filename pattern
                ->setLabel('Photo') // Custom label for the field
        ];
    }
    
}
