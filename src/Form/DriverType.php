<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Driver;
use App\Entity\Operator;
use App\Repository\CarRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DriverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('name')
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'choice_label' => 'mark',
                'multiple' => true,
                'query_builder' => function(CarRepository $cars){
                    return $cars->getOrderedCars();
                },
                'by_reference' => false
            ])
            ->add('operator', EntityType::class, [
                'class' => Operator::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Driver::class,
        ]);
    }
}
