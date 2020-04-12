<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="MENU", indexes={@ORM\Index(name="FK_OWNS", columns={"ID_FRANCHISE"})})
 * @ORM\Entity
 */
class Menu
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_MENU", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMenu;

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
     * @var \Franchises
     *
     * @ORM\ManyToOne(targetEntity="Franchises")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FRANCHISE", referencedColumnName="ID_FRANCHISE")
     * })
     */
    private $idFranchise;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="UserOrders", inversedBy="idMenu")
     * @ORM\JoinTable(name="concerns",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_MENU", referencedColumnName="ID_MENU")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_USER_ORDER", referencedColumnName="ID_USER_ORDER")
     *   }
     * )
     */
    private $idUserOrder;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Articles", mappedBy="idMenu")
     */
    private $idArticle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Rewards", mappedBy="idMenu")
     */
    private $idReward;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUserOrder = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idArticle = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idReward = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdMenu(): ?int
    {
        return $this->idMenu;
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

    public function getIdFranchise(): ?Franchises
    {
        return $this->idFranchise;
    }

    public function setIdFranchise(?Franchises $idFranchise): self
    {
        $this->idFranchise = $idFranchise;

        return $this;
    }

    /**
     * @return Collection|UserOrders[]
     */
    public function getIdUserOrder(): Collection
    {
        return $this->idUserOrder;
    }

    public function addIdUserOrder(UserOrders $idUserOrder): self
    {
        if (!$this->idUserOrder->contains($idUserOrder)) {
            $this->idUserOrder[] = $idUserOrder;
        }

        return $this;
    }

    public function removeIdUserOrder(UserOrders $idUserOrder): self
    {
        if ($this->idUserOrder->contains($idUserOrder)) {
            $this->idUserOrder->removeElement($idUserOrder);
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
            $idArticle->addIdMenu($this);
        }

        return $this;
    }

    public function removeIdArticle(Articles $idArticle): self
    {
        if ($this->idArticle->contains($idArticle)) {
            $this->idArticle->removeElement($idArticle);
            $idArticle->removeIdMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection|Rewards[]
     */
    public function getIdReward(): Collection
    {
        return $this->idReward;
    }

    public function addIdReward(Rewards $idReward): self
    {
        if (!$this->idReward->contains($idReward)) {
            $this->idReward[] = $idReward;
            $idReward->addIdMenu($this);
        }

        return $this;
    }

    public function removeIdReward(Rewards $idReward): self
    {
        if ($this->idReward->contains($idReward)) {
            $this->idReward->removeElement($idReward);
            $idReward->removeIdMenu($this);
        }

        return $this;
    }

}
