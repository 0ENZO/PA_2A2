<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaintenanceManuals
 *
 * @ORM\Table(name="MAINTENANCE_MANUALS", indexes={@ORM\Index(name="FK_HAS_TO_KEEP_UP", columns={"ID_TRUCK"})})
 * @ORM\Entity
 */
class MaintenanceManuals
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_MAINTENANCE_MANUAL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMaintenanceManual;

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMMATRICULATION", type="string", length=20, nullable=true)
     */
    private $immatriculation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="MILEAGE", type="integer", nullable=true)
     */
    private $mileage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="GREY_CARD", type="text", length=65535, nullable=true)
     */
    private $greyCard;

    /**
     * @var string|null
     *
     * @ORM\Column(name="INSURANCE", type="string", length=30, nullable=true)
     */
    private $insurance;

    /**
     * @var int|null
     *
     * @ORM\Column(name="AGE", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMMENT", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE", type="date", nullable=true)
     */
    private $date;

    /**
     * @var \Trucks
     *
     * @ORM\ManyToOne(targetEntity="Trucks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_TRUCK", referencedColumnName="ID_TRUCK")
     * })
     */
    private $idTruck;

    public function getIdMaintenanceManual(): ?int
    {
        return $this->idMaintenanceManual;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(?int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getGreyCard(): ?string
    {
        return $this->greyCard;
    }

    public function setGreyCard(?string $greyCard): self
    {
        $this->greyCard = $greyCard;

        return $this;
    }

    public function getInsurance(): ?string
    {
        return $this->insurance;
    }

    public function setInsurance(?string $insurance): self
    {
        $this->insurance = $insurance;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
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

    public function getIdTruck(): ?Trucks
    {
        return $this->idTruck;
    }

    public function setIdTruck(?Trucks $idTruck): self
    {
        $this->idTruck = $idTruck;

        return $this;
    }


}
