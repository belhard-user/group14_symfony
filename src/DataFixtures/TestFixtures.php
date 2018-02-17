<?php

namespace App\DataFixtures;


use App\Entity\Test;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TestFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i = 0; $i < 100; $i++){
            $test = new Test();
            $test->setIp($faker->ipv4)
                ->setName($faker->firstName())
            ;
            $manager->persist($test);
        }

        $manager->flush();
    }
}