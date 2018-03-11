<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('isPublish', ChoiceType::class, [
                'choices' => [
                    'Опубликовать' => true,
                    'Не опубликовать' => false,
                ],
            ])
            // https://github.com/symfony/symfony/issues/24307
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'title',
                'label' => 'Тэги',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
