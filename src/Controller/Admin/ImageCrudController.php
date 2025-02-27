<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setLabel('N°')->hideOnForm(), 
            ImageField::new('path')
            ->setColumns(12)
            ->setBasePath('/uploads/gallery') 
            ->setUploadDir('public/uploads/gallery') 
            ->setRequired(false) 
            ->setUploadedFileNamePattern('[randomhash].[extension]') 
            ->setLabel('photo'),
        ];
    }
    
}
