<?php

namespace App\Entity;

use App\Repository\WarehouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WarehouseRepository::class)
 */
class Warehouse
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
    private $name;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="warehouses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=MaxCapacity::class, inversedBy="warehouses")
     * @ORM\JoinColumn(nullable=true)
     */
    private $maxCapacity;

    /**
     * @ORM\OneToMany(targetEntity=FranchiseOrder::class, mappedBy="warehouse")
     */
    private $franchiseOrders;

    /**
     * @ORM\OneToMany(targetEntity=WarehouseStock::class, mappedBy="warehouse")
     */
    private $warehouseStocks;

    public function __construct()
    {
        $this->franchiseOrders = new ArrayCollection();
        $this->warehouseStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

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

    /**
     * @return Collection|FranchiseOrder[]
     */
    public function getFranchiseOrder(): Collection
    {
        return $this->franchiseOrders;
    }

    public function addFranchiseOrder(FranchiseOrder $franchiseOrder): self
    {
        if (!$this->franchiseOrders->contains($franchiseOrder)) {
            $this->franchiseOrders[] = $franchiseOrder;
            $franchiseOrder->setWarehouse($this);
        }

        return $this;
    }

    public function removeFranchiseOrder(FranchiseOrder $franchiseOrder): self
    {
        if ($this->franchiseOrders->contains($franchiseOrder)) {
            $this->franchiseOrders->removeElement($franchiseOrder);
            // set the owning side to null (unless already changed)
            if ($franchiseOrder->getWarehouse() === $this) {
                $franchiseOrder->setWarehouse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WarehouseStock[]
     */
    public function getWarehouseStocks(): Collection
    {
        return $this->warehouseStocks;
    }

    public function addWarehouseStock(WarehouseStock $warehouseStock): self
    {
        if (!$this->warehouseStocks->contains($warehouseStock)) {
            $this->warehouseStocks[] = $warehouseStock;
            $warehouseStock->setWarehouse($this);
        }

        return $this;
    }

    public function removeWarehouseStock(WarehouseStock $warehouseStock): self
    {
        if ($this->warehouseStocks->contains($warehouseStock)) {
            $this->warehouseStocks->removeElement($warehouseStock);
            // set the owning side to null (unless already changed)
            if ($warehouseStock->getWarehouse() === $this) {
                $warehouseStock->setWarehouse(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
