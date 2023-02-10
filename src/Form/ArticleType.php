<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $codePsotal = $options['codePostal'];
        $builder
            ->add('designation')
            ->add('description')
            ->add('prix')
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
