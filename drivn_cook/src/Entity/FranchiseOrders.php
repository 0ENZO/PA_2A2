<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FranchiseOrders
 *
 * @ORM\Table(name="FRANCHISE_ORDERS", indexes={@ORM\Index(name="FK_SEND_TO", columns={"ID_WAREHOUSE"}), @ORM\Index(name="FK_MAKE_FRANCHISE_ORDER", columns={"ID_FRANCHISE"})})
 * @ORM\Entity
 */
class FranchiseOrders
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_FRANCHISE_ORDER", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranchiseOrder;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMMENT", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", length=50, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="TOTAL_PRICE", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $totalPrice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="BILL", type="text", length=65535, nullable=true)
     */
    private $bill;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PURCHASE_FORM", type="text", length=65535, nullable=true)
     */
    private $purchaseForm;

    /**
     * @var \Franchises
     *
     * @ORM\ManyToOne(targetEntity="Franchises")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FRANCHISE", referencedColumnName="ID_FRANCHISE")
     * })
     */
    private $idFranchise;

    /**
     * @var \Warehouses
     *
     * @ORM\ManyToOne(targetEntity="Warehouses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_WAREHOUSE", referencedColumnName="ID_WAREHOUSE")
     * })
     */
    private $idWarehouse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Products", inversedBy="idFranchiseOrder")
     * @ORM\JoinTable(name="franchise_order_content",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_FRANCHISE_ORDER", referencedColumnName="ID_FRANCHISE_ORDER")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_PRODUCT", referencedColumnName="ID_PRODUCT")
     *   }
     * )
     */
    private $idProduct;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdFranchiseOrder(): ?int
    {
        return $this->idFranchiseOrder;
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

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getBill(): ?string
    {
        return $this->bill;
    }

    public function setBill(?string $bill): self
    {
        $this->bill = $bill;

        return $this;
    }

    public function getPurchaseForm(): ?string
    {
        return $this->purchaseForm;
    }

    public function setPurchaseForm(?string $purchaseForm): self
    {
        $this->purchaseForm = $purchaseForm;

        return $this;
    }

    public function getIdFranchise(): ?Franchises
    {
        return $this->idFranchise;
    }

    public function setIdFranchise(?Franchises $idFranchise): self
    {
        $this->idFranchise = $idFranchise;

        return $this;
    }

    public function getIdWarehouse(): ?Warehouses
    {
        return $this->idWarehouse;
    }

    public function setIdWarehouse(?Warehouses $idWarehouse): self
    {
        $this->idWarehouse = $idWarehouse;

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
        }

        return $this;
    }

    public function removeIdProduct(Products $idProduct): self
    {
        if ($this->idProduct->contains($idProduct)) {
            $this->idProduct->removeElement($idProduct);
        }

        return $this;
    }

}
