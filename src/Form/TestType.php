<?php

namespace App\Form;

use App\Entity\Test;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('ip')
            ->add('isActive', CheckboxType::class, [
                'label' => 'Активный',
                'attr' => [
                    'class' => 'foobar'
                ],
                'required' => false
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
        ;

        $this->ipDataTransformer($builder);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function ipDataTransformer(FormBuilderInterface $builder)
    {
        $builder->get('ip')
            ->addModelTransformer(new CallbackTransformer(
                function ($value) {
                    if (is_null($value)) {
                        return $_SERVER['REMOTE_ADDR'];
                    }

                    return $value;
                },
                function ($value) {
                    return $value;
                }
            ));
    }
}
