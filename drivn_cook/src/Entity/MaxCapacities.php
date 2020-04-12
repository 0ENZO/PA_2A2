<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaxCapacities
 *
 * @ORM\Table(name="MAX_CAPACITIES")
 * @ORM\Entity
 */
class MaxCapacities
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_MAX_CAPACITY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMaxCapacity;

    /**
     * @var int|null
     *
     * @ORM\Column(name="MAX_INGREDIENTS", type="integer", nullable=true)
     */
    private $maxIngredients;

    /**
     * @var int|null
     *
     * @ORM\Column(name="MAX_DRINKS", type="integer", nullable=true)
     */
    private $maxDrinks;

    /**
     * @var int|null
     *
     * @ORM\Column(name="MAX_DESSERTS", type="integer", nullable=true)
     */
    private $maxDesserts;

    /**
     * @var int|null
     *
     * @ORM\Column(name="MAX_MEALS", type="integer", nullable=true)
     */
    private $maxMeals;

    public function getIdMaxCapacity(): ?int
    {
        return $this->idMaxCapacity;
    }

    public function getMaxIngredients(): ?int
    {
        return $this->maxIngredients;
    }

    public function setMaxIngredients(?int $maxIngredients): self
    {
        $this->maxIngredients = $maxIngredients;

        return $this;
    }

    public function getMaxDrinks(): ?int
    {
        return $this->maxDrinks;
    }

    public function setMaxDrinks(?int $maxDrinks): self
    {
        $this->maxDrinks = $maxDrinks;

        return $this;
    }

    public function getMaxDesserts(): ?int
    {
        return $this->maxDesserts;
    }

    public function setMaxDesserts(?int $maxDesserts): self
    {
        $this->maxDesserts = $maxDesserts;

        return $this;
    }

    public function getMaxMeals(): ?int
    {
        return $this->maxMeals;
    }

    public function setMaxMeals(?int $maxMeals): self
    {
        $this->maxMeals = $maxMeals;

        return $this;
    }


}
