<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DriverRepository")
 * @ORM\Table(name="drivers")
 */
class Driver
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $number;


    /**
     * @ORM\OneToMany(targetEntity="Car", mappedBy="driver", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"mark" = "DESC"})
     */
    private $car;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Operator", mappedBy="drivers")
     */
    private $operator;

    
    public function __construct()
    {
        $this->car = new ArrayCollection();
        $this->operator = new ArrayCollection();
    }

    public function addOperator(Operator $operator)
    {
        if($this->operator->contains($operator)){
            return $this;
        }

        $this->operator[] = $operator;
        $operator->addDrivers($this);

        return $this;
    }

    public function removeOperator(Operator $operator)
    {
        $this->operator->removeElement($operator);
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|Car[]
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param mixed $cars
     */
    public function addCar(Car $cars)
    {
        $this->car[] = $cars;
        $cars->setDriver($this);
    }

    /**
     * @param Car $car
     */
    public function removeCar(Car $car)
    {
        $this->car->removeElement($car);
    }

    /**
     * @return ArrayCollection|Operator[]
     */
    public function getOperator()
    {
        return $this->operator;
    }


}
