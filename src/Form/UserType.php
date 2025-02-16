<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName')         
            ->add('LastName')
            ->add('Email')
            ->add('Entry_Date', DateType::class, [
                'label' => "Date d'entrée",
                'widget' => 'single_text',
                'required' => true, // Assure que le champ est obligatoire
                'input' => 'datetime', // Convertit bien la valeur en objet DateTime
            ])
            ->add('Password')
            ->add('Role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
