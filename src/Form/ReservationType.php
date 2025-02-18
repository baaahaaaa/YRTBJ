<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'choice_label' => 'Title',
                'label' => 'Event',
                'required' => false, 
                'empty_data' => '0', // Assure qu'une valeur est envoyée même si le champ est vide
                // Désactive la validation HTML5
                'placeholder' => 'Select an event',
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('NbPlaces', IntegerType::class, [
                'label' => 'Number of Places',
                'required' => false, 
                'empty_data' => '0', // Assure qu'une valeur est envoyée même si le champ est vide
                // Désactive la validation HTML5
            ])
            ->add('Total_price', NumberType::class, [
                'label' => 'Total Price',
                'required' => false,
                'empty_data' => '0', // Assure qu'une valeur est envoyée même si le champ est vide
                // Désactive la validation HTML5
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control'
                ]
            ])
            ->add('PhoneNumber', IntegerType::class, [
                'label' => 'Phone Number',
                'required' => false, // Désactive la validation HTML5
                'empty_data' => '0', // Assure qu'une valeur est envoyée même si le champ est vide

            ])
            ->add('Name', TextType::class, [
                'label' => 'Name',
                'required' => false, // Désactive la validation HTML5
                'empty_data' => '0', // Assure qu'une valeur est envoyée même si le champ est vide

            ])
            ->add('SpecialRequest', TextareaType::class, [
                'label' => 'Special Request',
                'required' => false, // Désactive la validation HTML5
                'empty_data' => '0', // Assure qu'une valeur est envoyée même si le champ est vide

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'attr' => ['novalidate' => 'novalidate'], // Désactive la validation HTML5 pour tout le formulaire
        ]);
    }
}
