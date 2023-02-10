<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse1', TextType::class, [
                'label' => 'Adresse',
                'help' => 'Exemple: 1 rue de la Paix',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('adresse2', TextType::class, [
                'label' => 'Complément d\'Adresse',
                'help' => 'Complément d\'adresse',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal',
                'help' => 'Exemple: 75000',
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '5',
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'help' => 'Exemple: Paris',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
