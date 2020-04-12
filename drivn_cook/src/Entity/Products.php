<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="PRODUCTS", indexes={@ORM\Index(name="FK_CATEGORIZED_BY", columns={"ID_CATEGORY"})})
 * @ORM\Entity
 */
class Products
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PRODUCT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMAGE", type="text", length=65535, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PRICE", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="STATUS", type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="VAT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $vat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="EXPIRY_DATE", type="date", nullable=true)
     */
    private $expiryDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="QUANTITY", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATEGORY", referencedColumnName="ID_CATEGORY")
     * })
     */
    private $idCategory;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="FranchiseOrders", mappedBy="idProduct")
     */
    private $idFranchiseOrder;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Franchises", mappedBy="idProduct")
     */
    private $idFranchise;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Articles", mappedBy="idProduct")
     */
    private $idArticle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Warehouses", inversedBy="idProduct")
     * @ORM\JoinTable(name="warehouse_stocks",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_PRODUCT", referencedColumnName="ID_PRODUCT")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_WAREHOUSE", referencedColumnName="ID_WAREHOUSE")
     *   }
     * )
     */
    private $idWarehouse;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idFranchiseOrder = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idFranchise = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idArticle = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

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

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(?string $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIdCategory(): ?Categories
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Categories $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * @return Collection|FranchiseOrders[]
     */
    public function getIdFranchiseOrder(): Collection
    {
        return $this->idFranchiseOrder;
    }

    public function addIdFranchiseOrder(FranchiseOrders $idFranchiseOrder): self
    {
        if (!$this->idFranchiseOrder->contains($idFranchiseOrder)) {
            $this->idFranchiseOrder[] = $idFranchiseOrder;
            $idFranchiseOrder->addIdProduct($this);
        }

        return $this;
    }

    public function removeIdFranchiseOrder(FranchiseOrders $idFranchiseOrder): self
    {
        if ($this->idFranchiseOrder->contains($idFranchiseOrder)) {
            $this->idFranchiseOrder->removeElement($idFranchiseOrder);
            $idFranchiseOrder->removeIdProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Franchises[]
     */
    public function getIdFranchise(): Collection
    {
        return $this->idFranchise;
    }

    public function addIdFranchise(Franchises $idFranchise): self
    {
        if (!$this->idFranchise->contains($idFranchise)) {
            $this->idFranchise[] = $idFranchise;
            $idFranchise->addIdProduct($this);
        }

        return $this;
    }

    public function removeIdFranchise(Franchises $idFranchise): self
    {
        if ($this->idFranchise->contains($idFranchise)) {
            $this->idFranchise->removeElement($idFranchise);
            $idFranchise->removeIdProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getIdArticle(): Collection
    {
        return $this->idArticle;
    }

    public function addIdArticle(Articles $idArticle): self
    {
        if (!$this->idArticle->contains($idArticle)) {
            $this->idArticle[] = $idArticle;
            $idArticle->addIdProduct($this);
        }

        return $this;
    }

    public function removeIdArticle(Articles $idArticle): self
    {
        if ($this->idArticle->contains($idArticle)) {
            $this->idArticle->removeElement($idArticle);
            $idArticle->removeIdProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Warehouses[]
     */
    public function getIdWarehouse(): Collection
    {
        return $this->idWarehouse;
    }

    public function addIdWarehouse(Warehouses $idWarehouse): self
    {
        if (!$this->idWarehouse->contains($idWarehouse)) {
            $this->idWarehouse[] = $idWarehouse;
        }

        return $this;
    }

    public function removeIdWarehouse(Warehouses $idWarehouse): self
    {
        if ($this->idWarehouse->contains($idWarehouse)) {
            $this->idWarehouse->removeElement($idWarehouse);
        }

        return $this;
    }

}
