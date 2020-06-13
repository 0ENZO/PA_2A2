<?php

namespace App\Entity;

use App\Repository\FranchiseOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FranchiseOrderRepository::class)
 */
class FranchiseOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="franchiseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $franchise;

    /**
     * @ORM\ManyToOne(targetEntity=Warehouse::class, inversedBy="franchiseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;

    /**
     * @ORM\OneToMany(targetEntity=FranchiseOrderContent::class, mappedBy="franchiseOrder")
     */
    private $franchiseOrderContents;

    public function __construct()
    {
        $this->franchiseOrderContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getFranchise(): ?Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(?Franchise $franchise): self
    {
        $this->franchise = $franchise;

        return $this;
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
            $franchiseOrderContent->setFranchiseOrder($this);
        }

        return $this;
    }

    public function removeFranchiseOrderContent(FranchiseOrderContent $franchiseOrderContent): self
    {
        if ($this->franchiseOrderContents->contains($franchiseOrderContent)) {
            $this->franchiseOrderContents->removeElement($franchiseOrderContent);
            // set the owning side to null (unless already changed)
            if ($franchiseOrderContent->getFranchiseOrder() === $this) {
                $franchiseOrderContent->setFranchiseOrder(null);
            }
        }

        return $this;
    }
}
