<?php

namespace App\Entity;

use App\Repository\MaintenanceManualRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaintenanceManualRepository::class)
 */
class MaintenanceManual
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Truck::class, inversedBy="maintenanceManuals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $truck;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="smallint")
     */
    private $mileage;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $insurance;

    /**
     * @ORM\Column(type="smallint")
     */
    private $age;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(?Truck $truck): self
    {
        $this->truck = $truck;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getInsurance(): ?string
    {
        return $this->insurance;
    }

    public function setInsurance(string $insurance): self
    {
        $this->insurance = $insurance;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
