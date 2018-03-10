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
    private $cars;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Operator", mappedBy="drivers")
     */
    private $operators;

    
    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->operators = new ArrayCollection();
    }

    public function addOperators(Operator $operator)
    {
        if($this->operators->contains($operator)){
            return $this;
        }

        $this->operators[] = $operator;
        $operator->addDrivers($this);

        return $this;
    }

    public function removeOperators(Operator $operator)
    {
        $this->operators->removeElement($operator);
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
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * @param mixed $cars
     */
    public function setCars(Car $cars)
    {
        $this->cars[] = $cars;
    }

    /**
     * @param Car $car
     */
    /*public function removeCars(Car $car)
    {
        $this->cars->removeElement($car);
    }*/

    /**
     * @return ArrayCollection|Operator[]
     */
    public function getOperators()
    {
        return $this->operators;
    }


}
