<?php

namespace App\Controller\Admin;

use App\Entity\Promotion;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Promotion::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setLabel('N°')->hideOnForm(),
           
            BooleanField::new('isPachIncluded')->setLabel('Inclus les packs')->setRequired(false)->setColumns(12),

            
            TextField::new('title')->setLabel('Titre')->setRequired(true)->setColumns(6),
            IntegerField::new('value')->setLabel('Promotion % ')->setRequired(true)->setColumns(6),
            
            AssociationField::new('categories')
            ->setFormTypeOptions([
                'by_reference' => false,  // Ensure that the association is properly updated
            ]) 
            ->setLabel('Catégories')->setRequired(true)->setColumns(6),
            

            AssociationField::new('subCategories')
            ->setFormTypeOptions([
                'by_reference' => false,  // Ensure that the association is properly updated
            ]) 
            ->setLabel('Sous-catégories')->setRequired(true)->setColumns(6),
            

            

            DateField::new('createdAt')->setLabel('Date de création')->setRequired(true)->setColumns(12)->hideOnForm(),
            DateField::new('startAt')->setLabel('Date début promotion')->setRequired(true)->setColumns(4),
            DateField::new('endAt')->setLabel('Date fin promotion % ')->setRequired(true)->setColumns(4),


           
            
            
        ];
    }




    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    { 

        
        if ($entityInstance instanceof Promotion) {
            if ($entityInstance->getCreatedAt() === null) {
                //$entityInstance->setEnStock(true);
                $entityInstance->setCreatedAt(new \DateTime());
            } 
        }
        
        parent::persistEntity($entityManager, $entityInstance);
        
        $this->addFlash('success', 'Promotion enregistré avec succès');

        
     }
    
}
