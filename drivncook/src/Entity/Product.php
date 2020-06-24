<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable 
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $vat;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expiryDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    /**
     * @ORM\Column(name="UploadDate" ,type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="products")
     */
    private $subCategory;

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

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageName")
     * @Assert\Image(
     *  maxSize = "5M",
     *  mimeTypes={ "image/gif", "image/jpeg", "image/png" }
     * )
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $imageName;

    public function __construct()
    {
        //$this->franchiseOrders = new ArrayCollection();
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

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function __toString()
    {
        return $this->name.' par '.$this->quantity.' '.$this->type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


    
}
