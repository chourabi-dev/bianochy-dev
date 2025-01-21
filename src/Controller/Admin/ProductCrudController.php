<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductImageType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/edit','admin/product/form_edit.html.twig');
    }
    
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
            AssociationField::new('category')->setColumns(12)->setLabel("Catégorie")->setFormTypeOption('choice_label', 'label'), 


            MoneyField::new('price')->setColumns(12)->setLabel("Prix")->setCurrency('TND'),
            BooleanField::new('enStock')->setColumns(12)->setLabel("En stock"),


            CollectionField::new('images')
            ->setEntryType(ProductImageType::class)
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            ->onlyOnForms()
            ->setColumns(12)
            ->setLabel("Images"),


            AssociationField::new('ingredient')->setColumns(12)
            ->setFormTypeOptions([
                'by_reference' => false,  // Ensure that the association is properly updated
            ])
            ->setLabel('Ingredients')
            ->onlyOnForms()  // Only display in form view
            ->setHelp('Sélectionnez les ingrédients pour ce produit'),
            
    
            TextEditorField::new('descreption')->setColumns(12)->setLabel("Description")->hideOnIndex(),
            TextEditorField::new('features')->setColumns(12)->setLabel("Caracteristiques")->hideOnIndex(),
            TextEditorField::new('howToUse')->setColumns(12)->setLabel("Nos conseils d'application")->hideOnIndex(),
            TextEditorField::new('delivery')->setColumns(12)->setLabel("Livraison")->hideOnIndex(),
            
             
            
            
            
            // category many to one entity feild
            
            DateTimeField::new('createdAt')->setLabel("Date d'ajout")->hideOnForm()
        ];
    }


    public function new(AdminContext $context)
    { 
        return parent::new($context);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    { 

        
        if ($entityInstance instanceof Product) {
            if ($entityInstance->getCreatedAt() === null) {
                $entityInstance->setCreatedAt(new \DateTime());
            }

           
            foreach ($entityInstance->getImages() as $image) {
                $file = $image->getFile(); 
                if ($file) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                        $this->getParameter('product_images_directory'),
                        $fileName
                    );
                    $image->setPath($fileName);
                }
            }   
        }
        
        parent::persistEntity($entityManager, $entityInstance);
        
        $this->addFlash('success', 'Produit enregistré avec succès');

        
     }



     public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Handle editing (updates) for Product entities
        if ($entityInstance instanceof Product) {
            
            // Handle image updates
            foreach ($entityInstance->getImages() as $image) {
                $file = $image->getFile();
                if ($file) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                        $this->getParameter('product_images_directory'),
                        $fileName
                    );
                    $image->setPath($fileName);
                }
            }
        }
        
        // Call the parent method to update the entity
        parent::updateEntity($entityManager, $entityInstance);
        
        // Flash success message
        $this->addFlash('success', 'Produit mis à jour avec succès');
    }
        
}
