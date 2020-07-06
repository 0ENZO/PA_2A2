<?php

namespace App\Entity;

use App\Repository\MaxCapacityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaxCapacityRepository::class)
 * @UniqueEntity(fields={"name"}, message="Une capacité ayant ce nom est déjà prise. Veuillez en sélectionner une autre")
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouver mettre ques des chiffres dans ce champs"
     * )
     */
    private $maxIngredients;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouver mettre ques des chiffres dans ce champs"
     * )
     */
    private $maxDrinks;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouver mettre ques des chiffres dans ce champs"
     * )
     */
    private $maxDesserts;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouver mettre ques des chiffres dans ce champs"
     * )
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

    public function __toString()
    {
        return $this->name;
    }
}
