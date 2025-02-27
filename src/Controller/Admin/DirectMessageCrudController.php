<?php

namespace App\Controller\Admin;

use App\Entity\DirectMessage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DirectMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DirectMessage::class;
    }


    public function configureActions(Actions $actions): Actions
    {
        $showAction = Action::new('show', 'Details')
            ->linkToCrudAction(Crud::PAGE_DETAIL);

        return $actions
            // Add SHOW and DELETE actions
            ->add(Crud::PAGE_INDEX, $showAction)
            //->add(Crud::PAGE_INDEX, Action::DELETE)

            // Disable other actions
            ->disable(Action::EDIT, Action::NEW);
    
    }


    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
