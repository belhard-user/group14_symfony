<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Car::class);
    }


    public function getOrderedCars()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.mark', 'ASC')
        ;
    }

}
