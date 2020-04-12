<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="ARTICLES", indexes={@ORM\Index(name="FK_ALSO_CATEGORIZED_BY", columns={"ID_CATEGORY"})})
 * @ORM\Entity
 */
class Articles
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_ARTICLE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArticle;

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
     * @ORM\Column(name="VAT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $vat;

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
     * @ORM\ManyToMany(targetEntity="Menu", inversedBy="idArticle")
     * @ORM\JoinTable(name="contains",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_ARTICLE", referencedColumnName="ID_ARTICLE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_MENU", referencedColumnName="ID_MENU")
     *   }
     * )
     */
    private $idMenu;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Products", inversedBy="idArticle")
     * @ORM\JoinTable(name="recipes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_ARTICLE", referencedColumnName="ID_ARTICLE")
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
        $this->idMenu = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idProduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
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

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(?string $vat): self
    {
        $this->vat = $vat;

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
     * @return Collection|Menu[]
     */
    public function getIdMenu(): Collection
    {
        return $this->idMenu;
    }

    public function addIdMenu(Menu $idMenu): self
    {
        if (!$this->idMenu->contains($idMenu)) {
            $this->idMenu[] = $idMenu;
        }

        return $this;
    }

    public function removeIdMenu(Menu $idMenu): self
    {
        if ($this->idMenu->contains($idMenu)) {
            $this->idMenu->removeElement($idMenu);
        }

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
