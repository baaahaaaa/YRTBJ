<?php

namespace App\Form;

use App\Entity\ComplaintResponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComplaintResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Response')
            ->add('DateResponse', null, [
                'widget' => 'single_text',
            ])
            ->add('Email_sender')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ComplaintResponse::class,
        ]);
    }
}
