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
            
            TextField::new('label')->setColumns(12)->setLabel("product.title"),
            TextField::new('subtitle')->setColumns(12)->setLabel("product.sub_title"), 
            AssociationField::new('category')->setColumns(6)->setLabel("product.category")->setFormTypeOption('choice_label', 'label'), 
            AssociationField::new('subCategory')->setColumns(6)->setLabel("product.sub_category"), 
            

            AssociationField::new('perfum')->setColumns(6)->setLabel("product.perfum"), 
            

            TextField::new('price')->setColumns(12)->setLabel("product.price"),
            BooleanField::new('enStock')->setColumns(12)->setLabel("product.in_stock"),


            CollectionField::new('images')
            ->setEntryType(ProductImageType::class)
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            ->onlyOnForms()
            ->setColumns(12)
            ->setLabel("product.images"),


            AssociationField::new('ingredient')->setColumns(12)
            ->setFormTypeOptions([
                'by_reference' => false,  // Ensure that the association is properly updated
            ])
            ->setLabel('product.ingredients')
            ->onlyOnForms()  // Only display in form view
            ->setHelp('Sélectionnez les ingrédients pour ce produit'),
            
    
            TextEditorField::new('descreption')->setColumns(12)->setLabel("product.description")->hideOnIndex(),
            TextEditorField::new('features')->setColumns(12)->setLabel("product.caracteristiques")->hideOnIndex(),
            TextEditorField::new('howToUse')->setColumns(12)->setLabel("product.how_to_use")->hideOnIndex(),
            TextEditorField::new('delivery')->setColumns(12)->setLabel("product.delivery")->hideOnIndex(),
            
              
            
            DateTimeField::new('createdAt')->setLabel("product.createdAt")->hideOnForm()
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
                $entityInstance->setEnStock(true);
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
