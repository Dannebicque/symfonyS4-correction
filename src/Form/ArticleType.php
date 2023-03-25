<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleCategorie;
use App\Entity\ArticleTypes;
use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $codePsotal = $options['codePostal'];
        $builder
            ->add('designation', TextType::class, [
                'label' => 'Désignation',
                'help' => 'La désignation de l\'article',
                'constraints' => [new Length(['min' => 5, 'max' => 5, 'minMessage' => 'La désignation doit faire au moins {{ limit }} caractères', 'maxMessage' => 'La désignation doit faire au plus {{ limit }} caractères'])],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'help' => 'La description de l\'article',
                'constraints' => [new NotBlank(['message' => 'La description ne peut pas être vide'])
            ]])
            ->add('prix', null, [
                'label' => 'Prix unitaire',
                'help' => 'Le prix unitaire de l\'article',
                'constraints' => [new NotBlank(['message' => 'Le prix ne peut pas être vide']), new Type(['type' => 'numeric', 'message' => 'Le prix doit être un nombre']), new Positive(['message' => 'Le prix doit être positif'])]
            ])
            ->add('quantiteDisponible')
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'libelle',
                'query_builder' => function (FournisseurRepository $fr) use ($codePsotal) {
                    return $fr->createQueryBuilder('f')
                        ->join('f.adresse', 'a')
                        ->where('a.codePostal = :codePostal')
                        ->setParameter('codePostal', $codePsotal)
                    ;
                },
            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'codePostal' => null
        ]);
    }
}
