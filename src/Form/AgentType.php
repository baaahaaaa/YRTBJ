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
           
        ])
        ->add('LastName', TextType::class, [
            'label' => 'Nom',
            'attr' => ['placeholder' => 'Entrez votre nom'],
            'required' => false,
            
        ])
        ->add('email', EmailType::class, [
            'label' => 'email',
            'attr' => ['placeholder' => 'Entrez votre email'],
            'required' => false,
            
        ])
        ->add('Entry_Date', DateType::class, [
            'label' => "Date d'entrée",
            'widget' => 'single_text',
            'html5' => false, // Désactive la validation HTML5 pour la date
            'attr' => ['class' => 'datepicker'],
            'required' => false,
            
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
            
        ])
        ->add('Location', TextType::class, [
            'label' => 'Localisation',
            'attr' => ['placeholder' => 'Entrez votre localisation'],
            'required' => false,
            
        ])
        ->add('CompanyName', TextType::class, [
            'label' => "Nom de l'entreprise",
            'attr' => ['placeholder' => "Entrez le nom de l'entreprise"],
            'required' => false,
            
        ])
        ;
    
        ;}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
