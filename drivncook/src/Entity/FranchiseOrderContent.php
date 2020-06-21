<?php

namespace App\Entity;

use App\Repository\FranchiseOrderContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FranchiseOrderContentRepository::class)
 */
class FranchiseOrderContent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=FranchiseOrder::class, inversedBy="franchiseOrderContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $franchiseOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="franchiseOrderContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFranchiseOrder(): ?FranchiseOrder
    {
        return $this->franchiseOrder;
    }

    public function setFranchiseOrder(?FranchiseOrder $franchiseOrder): self
    {
        $this->franchiseOrder = $franchiseOrder;

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
}
