<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class, [
                'label' => 'Date de réservation',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'col-md-3', // ajout de la classe Bootstrap
                ],
            ])
            ->add('arrivalHour', TimeType::class, [
                'label' => 'Heure de réservation',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'col-md-3', // ajout de la classe Bootstrap
                ]
                ])
            ->add('service', ChoiceType::class, [
                'label' => 'Service',
                'choices'  => [
                    'midi' => 'midi',
                    'soir' => 'soir',
                ],
                'attr' => [
                    'class' => 'form-check col-md-3', // ajout de la classe Bootstrap
                ],
            ])
            ->add('seats', NumberType::class, [
                'label' => 'Nombre de couverts',
                'attr' => [
                    'class' => 'col-md-3', // ajout de la classe Bootstrap,
                    'min' => 1,
                    'max' => 7,
                ],
                'invalid_message' => 'Le nombre de places à réserver est entre 1 et 7',
                'constraints' => [
                    new Assert\Range(min: 1, max: 7)
                ]
            ])

            ->add('allergy', TextareaType::class, [
                'label' => 'Commentaires éventuelles, allergies',
                'attr' => [
                    'class' => 'col-md-3', // ajout de la classe Bootstrap
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-dark mt-4'
                ],
                'label' => 'Réserver'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
