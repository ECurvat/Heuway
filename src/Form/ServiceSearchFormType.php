<?php

namespace App\Form;

use App\Entity\ServiceSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debut', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Début',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
            ])
            ->add('fin', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Fin',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
            ])
            ->add('depot', ChoiceType::class, [
                'choices' =>[
                    '' => null,
                    'MEY' => 'MEY',
                    'SPR' => 'SPR',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'label' => 'Dépôt',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
            ])
            ->add('ligne', ChoiceType::class, [
                'choices' => [
                    '' => null,
                    'T2' => 2,
                    'T4' => 4,
                    'T5' => 5,
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'label' => 'Ligne',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4 mb-4',
                ],
                'label' => 'Valider',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceSearch::class,
            'method' => 'get',
            'csrf_protection' => false, // car pas besoin de token pour faire une recherche
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
