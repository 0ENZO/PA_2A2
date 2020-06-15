<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Franchises
 *
 * @ORM\Table(name="FRANCHISES", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQUE", columns={"EMAIL"})}, indexes={@ORM\Index(name="FK_LIVE_AT", columns={"ID_ADRESSE"})})
 * @ORM\Entity(repositoryClass="App\Repository\FranchisesRepository")
 */
class Franchises implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_FRANCHISE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranchise;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="FIRST_NAME", type="string", length=50, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="LAST_NAME", type="string", length=50, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PROFILE_PICTURE", type="text", length=65535, nullable=true)
     */
    private $profilePicture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="BIRTH_DATE", type="date", nullable=false)
     */
    private $birthDate;

    /**
     * @var \Addresses
     *
     * @ORM\ManyToOne(targetEntity="Addresses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ADRESSE", referencedColumnName="ID_ADRESSE")
     * })
     */
    private $idAdresse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Products", inversedBy="idFranchise")
     * @ORM\JoinTable(name="franchise_stocks",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_FRANCHISE", referencedColumnName="ID_FRANCHISE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_PRODUCT", referencedColumnName="ID_PRODUCT")
     *   }
     * )
     */
    private $idProduct;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="idFranchise")
     * @ORM\JoinTable(name="participates",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_FRANCHISE", referencedColumnName="ID_FRANCHISE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_EVENT", referencedColumnName="ID_EVENT")
     *   }
     * )
     */
    private $idEvent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", inversedBy="idFranchise")
     * @ORM\JoinTable(name="votes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_FRANCHISE", referencedColumnName="ID_FRANCHISE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     *   }
     * )
     */
    private $idUser;

    /**
     * @ORM\OneToMany(targetEntity=CreditCards::class, mappedBy="franchises")
     */
    private $creditCard;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProduct = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idEvent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creditCard = new ArrayCollection();
    }

    public function getIdFranchise(): ?int
    {
        return $this->idFranchise;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getIdAdresse(): ?Addresses
    {
        return $this->idAdresse;
    }

    public function setIdAdresse(?Addresses $idAdresse): self
    {
        $this->idAdresse = $idAdresse;

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

    /**
     * @return Collection|Events[]
     */
    public function getIdEvent(): Collection
    {
        return $this->idEvent;
    }

    public function addIdEvent(Events $idEvent): self
    {
        if (!$this->idEvent->contains($idEvent)) {
            $this->idEvent[] = $idEvent;
        }

        return $this;
    }

    public function removeIdEvent(Events $idEvent): self
    {
        if ($this->idEvent->contains($idEvent)) {
            $this->idEvent->removeElement($idEvent);
        }

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(Users $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): self
    {
        if ($this->idUser->contains($idUser)) {
            $this->idUser->removeElement($idUser);
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

    /**
     * @return Collection|CreditCards[]
     */
    public function getCreditCard(): Collection
    {
        return $this->creditCard;
    }

    public function addCreditCard(CreditCards $creditCard): self
    {
        if (!$this->creditCard->contains($creditCard)) {
            $this->creditCard[] = $creditCard;
            $creditCard->setFranchises($this);
        }

        return $this;
    }

    public function removeCreditCard(CreditCards $creditCard): self
    {
        if ($this->creditCard->contains($creditCard)) {
            $this->creditCard->removeElement($creditCard);
            // set the owning side to null (unless already changed)
            if ($creditCard->getFranchises() === $this) {
                $creditCard->setFranchises(null);
            }
        }

        return $this;
    }

}