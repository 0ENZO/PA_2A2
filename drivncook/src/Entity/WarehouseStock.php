<?php

namespace App\Entity;

use App\Repository\WarehouseStockRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WarehouseStockRepository::class)
 * @UniqueEntity(
 *     fields={"warehouse", "product"},
 *     message="Le produit est dejà présent dans cet entrepôt. Veuillez l'éditer afin d'actualiser son contenu ou le supprimer."
 * )
 */
class WarehouseStock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Warehouse::class, inversedBy="warehouseStocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="warehouseStocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouver mettre ques des chiffres dans ce champs"
     * )
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(?Warehouse $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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

    public function __toString() {
        return "warehouse N°".$this->id." a ".$this->quantity." de produit N° ".$this->product;
    }
}
