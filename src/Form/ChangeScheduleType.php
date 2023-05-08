<?php

namespace App\Form;

use App\Entity\OpenHour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', TextType::class, [
                'disabled' => true,
                'label' => 'Jour',
                'attr' => [
                    'class' => 'form-control col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('mourningStartTime', TimeType::class, [
                'label' => 'Horaire d\'ouverture midi',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('mourningStopTime', TimeType::class, [
                'label' => 'Horaire de fermeture midi',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('eveningStartTime', TimeType::class, [
                'label' => 'Horaire d\'ouverture soir',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('eveningStopTime', TimeType::class, [
                'label' => 'Horaire de fermeture soir',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-custom mt-4'
                ],
                'label' => 'Mettre à jour'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpenHour::class,
        ]);
    }
}
