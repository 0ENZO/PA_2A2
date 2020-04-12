<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Franchises
 *
 * @ORM\Table(name="FRANCHISES", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQUE", columns={"EMAIL"})}, indexes={@ORM\Index(name="FK_LIVE_AT", columns={"ID_ADRESSE"})})
 * @ORM\Entity
 */
class Franchises
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
     * @var string|null
     *
     * @ORM\Column(name="EMAIL", type="string", length=200, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FIRST_NAME", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LAST_NAME", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PASSWORD", type="string", length=100, nullable=true)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PROFILE_PICTURE", type="text", length=65535, nullable=true)
     */
    private $profilePicture;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="BIRTH_DATE", type="date", nullable=true)
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
     * Constructor
     */
    public function __construct()
    {
        $this->idProduct = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idEvent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdFranchise(): ?int
    {
        return $this->idFranchise;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
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

    public function setBirthDate(?\DateTimeInterface $birthDate): self
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

}
