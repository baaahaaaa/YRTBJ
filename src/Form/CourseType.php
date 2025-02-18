<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Student;
use App\Entity\Tutor;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;  // Ajouté pour ChoiceType
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Description')
            ->add('Domain')
            ->add('Type', ChoiceType::class, [  // Utilisation de ChoiceType
                'choices' => [
                    'Paid' => 'paid',   // Valeur 'paid' sera stockée dans la base de données
                    'Free' => 'free',   // Valeur 'free' sera stockée dans la base de données
                ],
                'expanded' => false,  // Liste déroulante (false pour une liste, true pour des boutons radio)
                'multiple' => false,  // Un seul choix possible
            ])
            ->add('Price')
            ->add('CreationDate', null, [
                'widget' => 'single_text'
            ])
            ->add('tutor', EntityType::class, [
                'class' => Tutor::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}