<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Entrez votre prénom'],
                'required' => false, // Désactive la validation HTML5
            ])
            ->add('LastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Entrez votre nom'],
                'required' => false, // Désactive la validation HTML5
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Entrez votre email'],
                'required' => false, // Désactive la validation HTML5
            ])
            ->add('Entry_Date', DateType::class, [
                'label' => "Date d'entrée",
                'widget' => 'single_text',
                'required' => false, // Désactive la validation HTML5
                'html5' => false, // Désactive le datepicker HTML5
                'attr' => ['class' => 'datepicker'], // Ajoute un style personnalisé
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => false, // Désactive la validation HTML5
                'first_options'  => ['label' => 'Mot de passe', 'attr' => ['placeholder' => 'Mot de passe']],
                'second_options' => ['label' => 'Confirmer le mot de passe', 'attr' => ['placeholder' => 'Confirmer le mot de passe']],
            ])
            ->add('role', HiddenType::class, [
                'data' => 'Student',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
            'attr' => ['novalidate' => 'novalidate'], // Désactive la validation HTML5 au niveau du formulaire
        ]);
    }
}
