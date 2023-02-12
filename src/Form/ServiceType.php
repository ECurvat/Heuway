<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Service;
use App\Repository\ContratRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class ServiceType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder, 
        array $options
        ): void
    {
        $builder
            ->add('numero_groupe', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 200,
                ],
                'label' => 'Numéro de groupe',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Range([
                        'min' => 1,
                        'max' => 200,
                    ]),
                    new Assert\Positive()
                ],
            ])
            ->add('depot', ChoiceType::class, [
                'choices' =>[
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
                'constraints' => [
                    new Assert\NotNull(),
                ],
            ])
            ->add('ligne', ChoiceType::class, [
                'choices' => [
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
                'constraints' => [
                    new Assert\NotNull(),
                ],
            ])
            ->add('debut', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Début',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                ],
            ])
            ->add('fin', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Fin',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                ],
            ])
            ->add('pause', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Pause',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'required' => false,
                'empty_data' => '00:00',
            ])
            ->add('dispo', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Dispo',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'required' => false,
                'empty_data' => '00:00',
            ])
            ->add('deplacement', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Déplacement',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'required' => false,
                'empty_data' => '00:00',
            ])
            ->add('coupure', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Coupure',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'required' => false,
                'empty_data' => '00:00',
            ])
            ->add('contrat', EntityType::class, [
                'class' => Contrat::class,
                'choices' => $options['contrats'],
                'attr' => [
                    'class' => 'form-select',
                ],
                'label' => 'Contrat',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'empty_data' => '',
                'required' => false,
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
            'data_class' => Service::class,
            'contrats' => null,
        ]);
    }
}
