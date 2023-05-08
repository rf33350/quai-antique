<?php

namespace App\Form;

use App\Entity\Dish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeDishInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('Category', TextType::class, [
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('Description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('ImagePath', TextType::class, [
                'label' => 'Chemin du fichier',
                'disabled' => true,
                'attr' => [
                    'class' => 'col-md-4', // ajout de la classe Bootstrap
                ],
            ])
            ->add('button', ButtonType::class, [
                'attr' => [
                    'class' => 'btn btn-dark mt-4 changeImg'
                ],
                'label' => 'Changer d\'image',
            ])
            ->add('Price', NumberType::class, [
                'label' => 'Prix',
                'attr' => [
                    'class' => 'col-md-4', // ajout de la classe Bootstrap
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
            'data_class' => Dish::class,
        ]);
    }
}
