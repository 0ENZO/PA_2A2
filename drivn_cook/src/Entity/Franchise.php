<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FranchiseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=FranchiseRepository::class)
 */
class Franchise implements UserInterface
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

    /**
     * @ORM\OneToMany(targetEntity=SaleRecord::class, mappedBy="franchise")
     */
    private $saleRecords;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="franchise")
     */
    private $menus;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="franchise")
     */
    private $votes;

    public function __construct()
    {
        $this->trucks = new ArrayCollection();
        $this->franchiseOrders = new ArrayCollection();
        $this->saleRecords = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->votes = new ArrayCollection();
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

    /**
     * @return Collection|SaleRecord[]
     */
    public function getSaleRecords(): Collection
    {
        return $this->saleRecords;
    }

    public function addSaleRecord(SaleRecord $saleRecord): self
    {
        if (!$this->saleRecords->contains($saleRecord)) {
            $this->saleRecords[] = $saleRecord;
            $saleRecord->setFranchise($this);
        }

        return $this;
    }

    public function removeSaleRecord(SaleRecord $saleRecord): self
    {
        if ($this->saleRecords->contains($saleRecord)) {
            $this->saleRecords->removeElement($saleRecord);
            // set the owning side to null (unless already changed)
            if ($saleRecord->getFranchise() === $this) {
                $saleRecord->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setFranchise($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getFranchise() === $this) {
                $menu->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setFranchise($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getFranchise() === $this) {
                $vote->setFranchise(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
    * Returns the roles granted to the user.
    *
    *     public function getRoles()
    *     {
    *         return ['ROLE_USER'];
    *     }
    *
    * Alternatively, the roles might be stored on a ``roles`` property,
    * and populated in any number of different ways when the user object
    * is created.
    *
    * @return string[] The user roles
    */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
    * Returns the salt that was originally used to encode the password.
    *
    * This can return null if the password was not encoded using a salt.
    *
    * @return string|null The salt
    */
    public function getSalt()
    {
        return null;
    }

    /**
        * Removes sensitive data from the user.
        *
        * This is important if, at any given point, sensitive information like
        * the plain-text password is stored on this object.
        */
    public function eraseCredentials(){
        
    }
}
