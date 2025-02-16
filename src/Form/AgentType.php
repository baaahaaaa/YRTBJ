<?php
namespace App\Form;

use App\Entity\Agent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Entrez votre prénom'],
            ])
            ->add('LastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Entrez votre nom'],
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Entrez votre email'],
            ])
           ->add('Entry_Date', DateType::class, [
    'label' => "Date d'entrée",
    'widget' => 'single_text',
    'required' => true, // Rend la date obligatoire
    'html5' => true, // Active le sélecteur de date HTML5
])

->add('password', RepeatedType::class, [
    'type' => PasswordType::class,
    'invalid_message' => 'Les mots de passe doivent correspondre.',
    'options' => ['attr' => ['class' => 'form-control']],
    'required' => true,
    'first_options'  => ['label' => 'Mot de passe', 'attr' => ['placeholder' => 'Mot de passe']],
    'second_options' => ['label' => 'Confirmer le mot de passe', 'attr' => ['placeholder' => 'Confirmer le mot de passe']],
    'constraints' => [
        new NotBlank(['message' => 'Le mot de passe est obligatoire']),
        new Length(['min' => 6, 'minMessage' => 'Le mot de passe doit contenir au moins 6 caractères']),
    ],
])
            ->add('role', HiddenType::class, [
                'data' => 'Agent',
            ])
            ->add('Location', TextType::class, [
                'label' => 'Localisation',
            ])
            ->add('CompanyName', TextType::class, [
                'label' => "Nom de l'entreprise",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
