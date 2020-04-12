<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Warehouses
 *
 * @ORM\Table(name="WAREHOUSES", indexes={@ORM\Index(name="FK_RESIDE_IN", columns={"ID_ADRESSE"}), @ORM\Index(name="FK_LIMITED_BY", columns={"ID_MAX_CAPACITY"})})
 * @ORM\Entity
 */
class Warehouses
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_WAREHOUSE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWarehouse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PHONE_NUMBER", type="string", length=10, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EMAIL", type="string", length=200, nullable=true)
     */
    private $email;

    /**
     * @var \MaxCapacities
     *
     * @ORM\ManyToOne(targetEntity="MaxCapacities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MAX_CAPACITY", referencedColumnName="ID_MAX_CAPACITY")
     * })
     */
    private $idMaxCapacity;

    /**
     * @var \Addresses
     *
     * @ORM\ManyToOne(targetEntity="Addresses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ADRESSE", referencedColumnName="ID_ADRESSE")
     * })
     */
    private $idAdresse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Products", mappedBy="idWarehouse")
     */
    private $idProduct;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdWarehouse(): ?int
    {
        return $this->idWarehouse;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIdMaxCapacity(): ?MaxCapacities
    {
        return $this->idMaxCapacity;
    }

    public function setIdMaxCapacity(?MaxCapacities $idMaxCapacity): self
    {
        $this->idMaxCapacity = $idMaxCapacity;

        return $this;
    }

    public function getIdAdresse(): ?Addresses
    {
        return $this->idAdresse;
    }

    public function setIdAdresse(?Addresses $idAdresse): self
    {
        $this->idAdresse = $idAdresse;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getIdProduct(): Collection
    {
        return $this->idProduct;
    }

    public function addIdProduct(Products $idProduct): self
    {
        if (!$this->idProduct->contains($idProduct)) {
            $this->idProduct[] = $idProduct;
            $idProduct->addIdWarehouse($this);
        }

        return $this;
    }

    public function removeIdProduct(Products $idProduct): self
    {
        if ($this->idProduct->contains($idProduct)) {
            $this->idProduct->removeElement($idProduct);
            $idProduct->removeIdWarehouse($this);
        }

        return $this;
    }

}
