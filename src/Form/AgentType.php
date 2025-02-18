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
            'required' => false, // Désactive la validation HTML5
            'constraints' => [
                new NotBlank(['message' => 'Le prénom est obligatoire']),
            ],
        ])
        ->add('LastName', TextType::class, [
            'label' => 'Nom',
            'attr' => ['placeholder' => 'Entrez votre nom'],
            'required' => false,
            'constraints' => [
                new NotBlank(['message' => 'Le nom est obligatoire']),
            ],
        ])
        ->add('Email', EmailType::class, [
            'label' => 'Email',
            'attr' => ['placeholder' => 'Entrez votre email'],
            'required' => false,
            'constraints' => [
                new NotBlank(['message' => 'L\'email est obligatoire']),
            ],
        ])
        ->add('Entry_Date', DateType::class, [
            'label' => "Date d'entrée",
            'widget' => 'single_text',
            'html5' => false, // Désactive la validation HTML5 pour la date
            'attr' => ['class' => 'datepicker'],
            'required' => false,
            'constraints' => [
                new NotBlank(['message' => 'La date d\'entrée est obligatoire']),
            ],
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe doivent correspondre.',
            'options' => ['attr' => ['class' => 'form-control']],
            'required' => false,
            'first_options'  => [
                'label' => 'Mot de passe',
                'attr' => ['placeholder' => 'Mot de passe']
            ],
            'second_options' => [
                'label' => 'Confirmer le mot de passe',
                'attr' => ['placeholder' => 'Confirmer le mot de passe']
            ],
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
            'attr' => ['placeholder' => 'Entrez votre localisation'],
            'required' => false,
            'constraints' => [
                new NotBlank(['message' => 'La localisation est obligatoire']),
            ],
        ])
        ->add('CompanyName', TextType::class, [
            'label' => "Nom de l'entreprise",
            'attr' => ['placeholder' => "Entrez le nom de l'entreprise"],
            'required' => false,
            'constraints' => [
                new NotBlank(['message' => 'Le nom de l\'entreprise est obligatoire']),
            ],
        ]);}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
