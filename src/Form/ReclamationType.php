<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('user_name', TextType::class, [
            'label' => 'Your Name',
            'required' => false,

        ])
        ->add('email', TextType::class, [
            'label' => 'Your Email',
            'required' => false,

        ])
        ->add('subject', ChoiceType::class, [
            'choices'  => [
                'Problème technique' => 'problème technique',
                'Problème daccés' => 'Problème daccés',
                'Autre' => 'autre',
                'required' => false,

            ],
            'placeholder' => 'Sélectionnez un type',
            'label' => 'Subject',
            'required' => false,
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => false,

            

        ])
            ;
        }
            

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}