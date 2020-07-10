<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FranchiseRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FranchiseRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"email"}, message="Cette adresse email est déjà utilisée")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $completeAddress;

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
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phoneNumber;

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

    /**
     * @ORM\Column(type="boolean", options={"default"=0}, nullable=true)
     */
    private $isActivated;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="profile_images", fileNameProperty="imageName")
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

    /**
     * @ORM\OneToMany(targetEntity=CreditCard::class, mappedBy="franchise")
     */
    private $creditCards;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="franchise")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=FranchiseStock::class, mappedBy="franchise", orphanRemoval=true)
     */
    private $franchiseStocks;

    /**
     * @ORM\OneToMany(targetEntity=UserOrder::class, mappedBy="franchise")
     */
    private $userOrders;

    /**
     * @ORM\OneToMany(targetEntity=Notify::class, mappedBy="franchise")
     */
    private $notice;

    public function __construct()
    {
        $this->trucks = new ArrayCollection();
        $this->franchiseOrders = new ArrayCollection();
        $this->saleRecords = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->creditCards = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->franchiseStocks = new ArrayCollection();
        $this->userOrders = new ArrayCollection();
        $this->notice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCompleteAddress()
    {
        return $this->completeAddress;
    }

    /**
     * @param mixed $completeAddress
     */
    public function setCompleteAddress($completeAddress): void
    {
        $this->completeAddress = $completeAddress;
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

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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
    *         return ['ROLE_FRANCHISE'];
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
        return ['ROLE_FRANCHISE'];
        // return $this->role;
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

    /**
     * @return Collection|CreditCard[]
     */
    public function getCreditCards(): Collection
    {
        return $this->creditCards;
    }

    public function addCreditCard(CreditCard $creditCard): self
    {
        if (!$this->creditCards->contains($creditCard)) {
            $this->creditCards[] = $creditCard;
            $creditCard->setFranchise($this);
        }

        return $this;
    }

    public function removeCreditCard(CreditCard $creditCard): self
    {
        if ($this->creditCards->contains($creditCard)) {
            $this->creditCards->removeElement($creditCard);
            // set the owning side to null (unless already changed)
            if ($creditCard->getFranchise() === $this) {
                $creditCard->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addFranchise($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeFranchise($this);
        }

        return $this;
    }

    /**
     * @return Collection|FranchiseStock[]
     */
    public function getFranchiseStocks(): Collection
    {
        return $this->franchiseStocks;
    }

    public function addFranchiseStock(FranchiseStock $franchiseStock): self
    {
        if (!$this->franchiseStocks->contains($franchiseStock)) {
            $this->franchiseStocks[] = $franchiseStock;
            $franchiseStock->setFranchise($this);
        }

        return $this;
    }

    public function removeFranchiseStock(FranchiseStock $franchiseStock): self
    {
        if ($this->franchiseStocks->contains($franchiseStock)) {
            $this->franchiseStocks->removeElement($franchiseStock);
            // set the owning side to null (unless already changed)
            if ($franchiseStock->getFranchise() === $this) {
                $franchiseStock->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     * @param mixed $isActivated
     */
    public function setIsActivated($isActivated): self
    {
        $this->isActivated = $isActivated;
        return $this;
    }

    /**
     * @return Collection|UserOrder[]
     */
    public function getUserOrders(): Collection
    {
        return $this->userOrders;
    }

    public function addUserOrder(UserOrder $userOrder): self
    {
        if (!$this->userOrders->contains($userOrder)) {
            $this->userOrders[] = $userOrder;
            $userOrder->setFranchise($this);
        }

        return $this;
    }

    public function removeUserOrder(UserOrder $userOrder): self
    {
        if ($this->userOrders->contains($userOrder)) {
            $this->userOrders->removeElement($userOrder);
            // set the owning side to null (unless already changed)
            if ($userOrder->getFranchise() === $this) {
                $userOrder->setFranchise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notify[]
     */
    public function getNotice(): Collection
    {
        return $this->notice;
    }

    public function addNotice(Notify $notice): self
    {
        if (!$this->notice->contains($notice)) {
            $this->notice[] = $notice;
            $notice->setFranchise($this);
        }

        return $this;
    }

    public function removeNotice(Notify $notice): self
    {
        if ($this->notice->contains($notice)) {
            $this->notice->removeElement($notice);
            // set the owning side to null (unless already changed)
            if ($notice->getFranchise() === $this) {
                $notice->setFranchise(null);
            }
        }

        return $this;
    }



}
