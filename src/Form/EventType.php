<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Title', TextType::class, [
            'required' => false, // Désactive la validation HTML5
            'constraints' => [
                new NotBlank(['message' => 'Le titre est obligatoire.']) // Symfony valide côté serveur
            ]
        ])
        ->add('Type', TextType::class, [
            'required' => false, // Désactive la validation HTML5
            'constraints' => [
                new NotBlank(['message' => 'Le type est obligatoire.'])
            ]
        ])    
        ->add('Description', TextType::class, [
            'required' => false, // Désactive la validation HTML5
            'constraints' => [
                new NotBlank(['message' => 'Le type est obligatoire.'])
            ]
        ])    
            ->add('Location', TextType::class, [
            'required' => false,
            'constraints' => [
                new NotBlank(['message' => 'L\'emplacement est obligatoire.'])
            ]
        ])
        ->add('Date_event', DateType::class, [
            'widget' => 'single_text',
            'required' => false, // Permet au champ d'être vide
            'empty_data' => '',  // Évite une conversion de null vers DateTimeInterface
            'html5' => true,
            'attr' => ['class' => 'datepicker'], // Optionnel pour un datepicker
        ])
        ->add('Price', NumberType::class, [
            'required' => false,
            'constraints' => [
                new NotBlank(['message' => 'Le prix est obligatoire.'])
            ]
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}