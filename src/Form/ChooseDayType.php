<?php

namespace App\Form;

use App\Entity\OpenHour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseDayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', TextType::class, [
                'label' => 'Jour',
                'attr' => [
                    'class' => 'col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-dark mt-4'
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
