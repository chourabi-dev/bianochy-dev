<?php

namespace App\Controller\Admin;

use App\Entity\Banner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;

class BannerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Banner::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setLabel('N°'), 
            TextField::new('title')->setColumns(6)->setLabel('Titre'),
            
            TextEditorField::new('content')->setColumns(6)->setLabel('contenu'),
            
            TextField::new('link')->setColumns(6)->setLabel('Lien'),
             
            
            ImageField::new('photo')
                ->setColumns(6)
                ->setBasePath('/uploads/banners') // Folder where the images will be stored
                ->setUploadDir('public/uploads/banners') // Directory for uploaded images
                ->setRequired(true) // Make this field optional
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Unique filename pattern
                ->setLabel('Icon') // Custom label for the field
        ];
    }
    
}
