<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperatorRepository")
 * @ORM\Table(name="operators")
 */
class Operator
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Driver", inversedBy="operator")
     */
    private $drivers;


    public function __construct()
    {
        $this->drivers = new ArrayCollection();
    }

    public function addDrivers(Driver $driver)
    {
        if ($this->drivers->contains($driver)) {
            return $this;
        }

        $this->drivers[] = $driver;
        $driver->addOperator($this);

        return $this;
    }

    public function removeDrivers(Driver $driver)
    {
        $this->drivers->removeElement($driver);
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDrivers()
    {
        return $this->drivers;
    }
}
