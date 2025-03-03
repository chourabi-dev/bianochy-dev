<?php

namespace App\Form;

use App\Entity\DirectMessage;
use App\Entity\DirectMessge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DirectMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('fullname',TextType::class,[ 
                'label' => false,
                'required'=>true, 
                'attr'=>[
                    'class'=>'contact-us-control mb-4',
                    'placeholder'=>'NOM'
                ]
            ]) 
            ->add('email',TextType::class,[
                'label' => false,
                'required'=>true,
                'attr'=>[
                    'class'=>'contact-us-control mb-4',
                    'placeholder'=>'EMAIL'
                ]
            ]) 
            ->add('content',TextareaType::class,[
                'label' => false,
                'required'=>true,
                'attr'=>[
                    'class'=>'contact-us-control mb-4',
                    'placeholder'=>'MESSAGE:',
                    'rows'=>10
                ]
            ]) 
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DirectMessage::class,
        ]);
    }
}
