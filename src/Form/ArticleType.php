<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('date_publication')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
            ])
            ->add('image' , FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'constraints' => [
                    new Assert\File(
                        maxSize: '1024k',
                        extensions: ['png', 'jpg', 'jpeg', 'webp'],
                        extensionsMessage: 'Veuillez choisir une image en png, jpg, jpeg ou webp.',
                    )
                ],
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
