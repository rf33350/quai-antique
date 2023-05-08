<?php

namespace App\Form;

use App\Entity\Dish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class DishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('Category', TextType::class, [
                'label' => 'Catégorie',
            ])
            ->add('Description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('ImagePath', TextType::class, [
                'label' => 'Chemin de fichier',
                'disabled' => true,
            ])
            ->add('ImageFile', VichImageType::class, [
                'label' => 'Image à uploader',
                'attr' => [
                    'accept' => 'image/jpeg,image/png,image/gif,image/jpg',
                ],
                'asset_helper' => true,
            ])
            ->add('Price', NumberType::class, [
                'label' => 'Prix',
            ])
            ->add('isStar',ChoiceType::class, [
                    'label' => 'Afficher en page d\'accueil?',
                    'choices' => [
                        'true' => 1,
                        'false' => 0,
                    ],
                    'attr' => [
                    'class' => 'form-control', // ajout de la classe Bootstrap
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dish::class,
        ]);
    }
}
