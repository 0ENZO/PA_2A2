<?php

namespace App\Entity;

use App\Repository\UserOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserOrderRepository::class)
 */
class UserOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userOrders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

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
     * @ORM\OneToMany(targetEntity=UserOrderContent::class, mappedBy="userOrder")
     */
    private $userOrderContents;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="userOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $franchise;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $completeAddress;

    public function __construct()
    {
        $this->userOrderContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    /**
     * @return Collection|UserOrderContent[]
     */
    public function getUserOrderContents(): Collection
    {
        return $this->userOrderContents;
    }

    public function addUserOrderContent(UserOrderContent $userOrderContent): self
    {
        if (!$this->userOrderContents->contains($userOrderContent)) {
            $this->userOrderContents[] = $userOrderContent;
            $userOrderContent->setUserOrder($this);
        }

        return $this;
    }

    public function removeUserOrderContent(UserOrderContent $userOrderContent): self
    {
        if ($this->userOrderContents->contains($userOrderContent)) {
            $this->userOrderContents->removeElement($userOrderContent);
            // set the owning side to null (unless already changed)
            if ($userOrderContent->getUserOrder() === $this) {
                $userOrderContent->setUserOrder(null);
            }
        }

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

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCompleteAddress(): ?string
    {
        return $this->completeAddress;
    }

    public function setCompleteAddress(?string $completeAddress): self
    {
        $this->completeAddress = $completeAddress;

        return $this;
    }
}
