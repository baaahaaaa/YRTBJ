<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('description', TextareaType::class, [
            'label' => 'Réponse',
            'attr' => ['class' => 'form-control', 'rows' => 5],
        ])
        ->add('createdAt', DateTimeType::class, [
            'widget' => 'single_text',
            'label' => 'Date de création',
            'data' => new \DateTimeImmutable(), // Définit la date actuelle par défaut
            'disabled' => true, // Empêche la modification
        ])
        ->add('reclamation', EntityType::class, [
            'class' => Reclamation::class,
            'choice_label' => 'subject', // Affiche le sujet de la réclamation
            'label' => 'Réclamation associée',
            'attr' => ['class' => 'form-control'],
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}