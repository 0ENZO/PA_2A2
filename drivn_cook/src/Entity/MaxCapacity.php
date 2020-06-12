<?php

namespace App\Entity;

use App\Repository\MaxCapacityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaxCapacityRepository::class)
 */
class MaxCapacity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxIngredients;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxDrinks;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxDesserts;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxMeals;

    /**
     * @ORM\OneToMany(targetEntity=Truck::class, mappedBy="maxCapacity")
     */
    private $trucks;

    /**
     * @ORM\OneToMany(targetEntity=Warehouse::class, mappedBy="maxCapacity")
     */
    private $warehouses;

    public function __construct()
    {
        $this->trucks = new ArrayCollection();
        $this->warehouses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxIngredients(): ?int
    {
        return $this->maxIngredients;
    }

    public function setMaxIngredients(int $maxIngredients): self
    {
        $this->maxIngredients = $maxIngredients;

        return $this;
    }

    public function getMaxDrinks(): ?int
    {
        return $this->maxDrinks;
    }

    public function setMaxDrinks(int $maxDrinks): self
    {
        $this->maxDrinks = $maxDrinks;

        return $this;
    }

    public function getMaxDesserts(): ?int
    {
        return $this->maxDesserts;
    }

    public function setMaxDesserts(int $maxDesserts): self
    {
        $this->maxDesserts = $maxDesserts;

        return $this;
    }

    public function getMaxMeals(): ?int
    {
        return $this->maxMeals;
    }

    public function setMaxMeals(int $maxMeals): self
    {
        $this->maxMeals = $maxMeals;

        return $this;
    }

    /**
     * @return Collection|Truck[]
     */
    public function getTrucks(): Collection
    {
        return $this->trucks;
    }

    public function addTruck(Truck $truck): self
    {
        if (!$this->trucks->contains($truck)) {
            $this->trucks[] = $truck;
            $truck->setMaxCapacity($this);
        }

        return $this;
    }

    public function removeTruck(Truck $truck): self
    {
        if ($this->trucks->contains($truck)) {
            $this->trucks->removeElement($truck);
            // set the owning side to null (unless already changed)
            if ($truck->getMaxCapacity() === $this) {
                $truck->setMaxCapacity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Warehouse[]
     */
    public function getWarehouses(): Collection
    {
        return $this->warehouses;
    }

    public function addWarehouse(Warehouse $warehouse): self
    {
        if (!$this->warehouses->contains($warehouse)) {
            $this->warehouses[] = $warehouse;
            $warehouse->setMaxCapacity($this);
        }

        return $this;
    }

    public function removeWarehouse(Warehouse $warehouse): self
    {
        if ($this->warehouses->contains($warehouse)) {
            $this->warehouses->removeElement($warehouse);
            // set the owning side to null (unless already changed)
            if ($warehouse->getMaxCapacity() === $this) {
                $warehouse->setMaxCapacity(null);
            }
        }

        return $this;
    }
}
