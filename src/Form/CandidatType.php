<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date_candidature', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => '',
                'html5' => true,
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('Email', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'L\'email est obligatoire.']),
                    new Email(['message' => 'Veuillez entrer une adresse email valide.']),
                ],
            ])
            ->add('PhoneNumber', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Le numéro de téléphone est obligatoire.']),
                    new Regex([
                        'pattern' => '/^\d{8}$/',
                        'message' => 'Le numéro de téléphone doit contenir exactement 8 chiffres.',
                    ]),
                ],
            ])
            
            ->add('FullName', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Le nom complet est obligatoire.']),
                    new Length([
                        'min' => 5,
                        'max' => 100,
                        'minMessage' => 'Le nom complet doit contenir au moins 5 caractères.',
                        'maxMessage' => 'Le nom complet ne peut pas dépasser 100 caractères.',
                    ]),
                ],
            ])
            ->add('Result', ChoiceType::class, [
                'choices' => [
                    'Accepté' => true,
                    'Refusé' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
            ])
            ->add('cv', FileType::class, [
                'label' => 'CV (PDF uniquement)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['application/pdf'],
                        'mimeTypesMessage' => 'Le CV doit être un fichier PDF de 2 Mo maximum.',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
