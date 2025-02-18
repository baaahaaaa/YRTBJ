<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Ressource;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('format', ChoiceType::class, [
                'choices' => [
                    'PDF' => 'pdf',
                    'Image' => 'image',
                    'Vidéo' => 'video',
                ],
                'placeholder' => 'Select a format',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Format',
            ])
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Creation Date',
            ])
            ->add('courses', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'id', // Vous pouvez changer cela si besoin
                'label' => 'Course',
            ])
            ->add('file', FileType::class, [
                'label' => 'Upload File',
                'mapped' => false,  // Not linked to entity directly
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'application/pdf'],
                        'mimeTypesMessage' => 'Please upload a valid file (JPG, PNG, or PDF)',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}