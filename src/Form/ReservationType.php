<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hours = ['12h00', '12h15', '12h30', '12h45', '13h00', '13h15', '13h30', '13h45'];

        $dates = $options['dates'];

        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '255',
                    'placeholder' => 'Merci de renseigner votre prénom',
                ],
                'label' => 'Prénom',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255]),
                ],
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '255',
                    'placeholder' => 'Merci de renseigner votre nom',
                ],
                'label' => 'Nom',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '255',
                    'placeholder' => 'Merci de renseigner votre email',
                ],
                'label' => 'Email',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255]),
                ],
            ])
            ->add('date',DateType::class, [
                'label' => 'Date de réservation',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datepicker', // ajout de la classe Bootstrap
                    'data-disabled-dates' => json_encode($dates),
                ],
                'constraints' => [
                    new Assert\GreaterThan('today'),
                ],
            ])
            ->add('service', ChoiceType::class, [
                'label' => 'Service',
                'placeholder' => 'Choisir un service',
                'choices'  => [
                    'midi' => 'midi',
                    'soir' => 'soir',
                ],
                'attr' => [
                    'class' => 'reservationFormService form-control', // ajout de la classe Bootstrap
                ],
            ])
            ->add('arrivalHour', ChoiceType::class, [
                'label' => 'Heure de réservation',
                'mapped' => false,
                'choices' => [
                    '12h00' => '12:00:00',
                    '12h15' => '12:15:00',
                    '12h30' => '12:30:00',
                    '12h45' => '12:45:00',
                    '13h00' => '13:00:00',
                    '13h15' => '13:15:00',
                    '13h30' => '13:30:00',
                    '13h45' => '13:45:00',
                    '19h30' => '19:30:00',
                    '19h45' => '19:45:00',
                    '20h00' => '20:00:00',
                    '20h15' => '20:15:00',
                    '20h30' => '20:30:00',
                    '20h45' => '20:45:00',
                    '21h00' => '21:00:00',
                    '21h15' => '21:15:00',
                ],
                'placeholder' => 'Choisir une heure',
                'attr' => [
                    'class' => 'arrival_hour form-control', // ajout de la classe Bootstrap
                ],
            ])

            ->add('seats', NumberType::class, [
                'label' => 'Nombre de couverts',
                'attr' => [
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
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-custom mt-4'
                ],
                'label' => 'Réserver'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'dates' => [],
        ]);
    }
}
