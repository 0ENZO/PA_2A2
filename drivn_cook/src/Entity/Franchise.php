<?php

namespace App\Entity;

use App\Repository\FranchiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FranchiseRepository::class)
 */
class Franchise
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="franchises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="franchises")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Truck::class, mappedBy="franchise")
     */
    private $trucks;

    /**
     * @ORM\OneToMany(targetEntity=FranchiseOrder::class, mappedBy="franchise")
     */
    private $franchiseOrders;

    public function __construct()
    {
        $this->trucks = new ArrayCollection();
        $this->franchiseOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Truck[]
     */
    public function getTrucks(): Collection
    {
        return $this->trucks;
    }

    public function addTruck(Truck $truck): self
    {
        if (!$this->trucks->contains($truck)) {
            $this->trucks[] = $truck;
            $truck->setFranchise($this);
        }

        return $this;
    }

    public function removeTruck(Truck $truck): self
    {
        if ($this->trucks->contains($truck)) {
            $this->trucks->removeElement($truck);
            // set the owning side to null (unless already changed)
            if ($truck->getFranchise() === $this) {
                $truck->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FranchiseOrder[]
     */
    public function getFranchiseOrders(): Collection
    {
        return $this->franchiseOrders;
    }

    public function addFranchiseOrder(FranchiseOrder $franchiseOrder): self
    {
        if (!$this->franchiseOrders->contains($franchiseOrder)) {
            $this->franchiseOrders[] = $franchiseOrder;
            $franchiseOrder->setFranchise($this);
        }

        return $this;
    }

    public function removeFranchiseOrder(FranchiseOrder $franchiseOrder): self
    {
        if ($this->franchiseOrders->contains($franchiseOrder)) {
            $this->franchiseOrders->removeElement($franchiseOrder);
            // set the owning side to null (unless already changed)
            if ($franchiseOrder->getFranchise() === $this) {
                $franchiseOrder->setFranchise(null);
            }
        }

        return $this;
    }
}
