<?php

namespace App\Entity;

use App\Repository\UserOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
     *  @Assert\Type(type="string")
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     *  @Assert\DateTime()
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(
     *     "today UTC",
     *     message="La date ne peut pas être avant aujourd'hui"
     * )
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un statut  à 0 caractère minimum",
     *     max="50",
     *     maxMessage="Vous devez mettre un statut  à 50 caractères maximum"
     * )
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
     * @Assert\Type(type="float")
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre une adresse  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre une adresse  à 255 caractères maximum"
     * )
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
