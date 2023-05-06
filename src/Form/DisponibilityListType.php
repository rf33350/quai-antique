<?php

namespace App\Form;

use App\Entity\Disponibility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisponibilityListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date-debut', DateType::class, [
                'label' => 'Date de début',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'mapped' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'col-md-3', // ajout de la classe Bootstrap
                ]
            ])
            ->add('date-fin', DateType::class, [
                'label' => 'Date de fin',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'mapped' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'col-md-3', // ajout de la classe Bootstrap
                ],
            ])
            ->add('availableSeats', NumberType::class, [
                'label' => 'Nombre de places disponibles',
                'attr' => [
                    'class' => 'col-md-3', // ajout de la classe Bootstrap
                ]
            ])
            ->add('restaurant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibility::class,
        ]);
    }
}
