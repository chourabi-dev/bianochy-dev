<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setLabel('N°'), 
            TextField::new('label')->setColumns(6)->setLabel('Titre'),
            ImageField::new('icon')
                ->setColumns(6)
                ->setBasePath('/uploads/icons') // Folder where the images will be stored
                ->setUploadDir('public/uploads/icons') // Directory for uploaded images
                ->setRequired(true) // Make this field optional
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Unique filename pattern
                ->setLabel('Icon') // Custom label for the field
        ];
    }




    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Category ) {
            $this->addFlash(
                'success',
                'Categorie enregistré avec succès'
             );
        }
        
        parent::persistEntity($entityManager, $entityInstance);

        
     }
    
}
