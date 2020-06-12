<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TruckRepository::class)
 */
class Truck
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $factoryDate;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="trucks")
     */
    private $franchise;

    /**
     * @ORM\ManyToOne(targetEntity=MaxCapacity::class, inversedBy="trucks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $maxCapacity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFactoryDate(): ?\DateTimeInterface
    {
        return $this->factoryDate;
    }

    public function setFactoryDate(\DateTimeInterface $factoryDate): self
    {
        $this->factoryDate = $factoryDate;

        return $this;
    }

    public function getFranchise(): ?Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(?Franchise $franchise): self
    {
        $this->franchise = $franchise;

        return $this;
    }

    public function getMaxCapacity(): ?MaxCapacity
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(?MaxCapacity $maxCapacity): self
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }
}
