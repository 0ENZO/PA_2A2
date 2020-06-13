<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $vat;

    /**
     * @ORM\Column(type="date")
     */
    private $expiryDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=FranchiseOrder::class, mappedBy="content")
     */
    private $franchiseOrders;

    /**
     * @ORM\OneToMany(targetEntity=FranchiseOrderContent::class, mappedBy="product")
     */
    private $franchiseOrderContents;

    /**
     * @ORM\OneToMany(targetEntity=Recipe::class, mappedBy="product")
     */
    private $recipes;

    /**
     * @ORM\OneToMany(targetEntity=WarehouseStock::class, mappedBy="product")
     */
    private $warehouseStocks;

    public function __construct()
    {
        $this->franchiseOrders = new ArrayCollection();
        $this->franchiseOrderContents = new ArrayCollection();
        $this->recipes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
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

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $franchiseOrder->addContent($this);
        }

        return $this;
    }

    public function removeFranchiseOrder(FranchiseOrder $franchiseOrder): self
    {
        if ($this->franchiseOrders->contains($franchiseOrder)) {
            $this->franchiseOrders->removeElement($franchiseOrder);
            $franchiseOrder->removeContent($this);
        }

        return $this;
    }

    /**
     * @return Collection|FranchiseOrderContent[]
     */
    public function getFranchiseOrderContents(): Collection
    {
        return $this->franchiseOrderContents;
    }

    public function addFranchiseOrderContent(FranchiseOrderContent $franchiseOrderContent): self
    {
        if (!$this->franchiseOrderContents->contains($franchiseOrderContent)) {
            $this->franchiseOrderContents[] = $franchiseOrderContent;
            $franchiseOrderContent->setProduct($this);
        }

        return $this;
    }

    public function removeFranchiseOrderContent(FranchiseOrderContent $franchiseOrderContent): self
    {
        if ($this->franchiseOrderContents->contains($franchiseOrderContent)) {
            $this->franchiseOrderContents->removeElement($franchiseOrderContent);
            // set the owning side to null (unless already changed)
            if ($franchiseOrderContent->getProduct() === $this) {
                $franchiseOrderContent->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recipe[]
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
            $recipe->setProduct($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->contains($recipe)) {
            $this->recipes->removeElement($recipe);
            // set the owning side to null (unless already changed)
            if ($recipe->getProduct() === $this) {
                $recipe->setProduct(null);
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
            $warehouseStock->setProduct($this);
        }

        return $this;
    }

    public function removeWarehouseStock(WarehouseStock $warehouseStock): self
    {
        if ($this->warehouseStocks->contains($warehouseStock)) {
            $this->warehouseStocks->removeElement($warehouseStock);
            // set the owning side to null (unless already changed)
            if ($warehouseStock->getProduct() === $this) {
                $warehouseStock->setProduct(null);
            }
        }

        return $this;
    }
}
