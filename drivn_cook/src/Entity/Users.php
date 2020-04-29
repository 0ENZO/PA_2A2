<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="USERS", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQUE", columns={"EMAIL"})}, indexes={@ORM\Index(name="FK_TAKE_PERMISSIONS_FROM", columns={"ID_ROLE"})})
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_USER", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="PSEUDO", type="string", length=30, nullable=false)
     */
    private $pseudo;

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
     * @ORM\Column(name="EMAIL", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PHONE_NUMBER", type="string", length=10, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="EURO_POINTS", type="integer", nullable=true)
     */
    private $euroPoints;

    /**
     * @var int|null
     *
     * @ORM\Column(name="FORMULE_POINTS", type="integer", nullable=true)
     */
    private $formulePoints;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="IS_ACTIVATED", type="boolean", nullable=true)
     */
    private $isActivated;

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="BIRTH_DATE", type="date", nullable=false)
     */
    private $birthDate;

    /**
     * @var \Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ROLE", referencedColumnName="ID_ROLE")
     * })
     */
    private $idRole;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Addresses", mappedBy="idUser")
     */
    private $idAdresse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Rewards", inversedBy="idUser")
     * @ORM\JoinTable(name="can_claim",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_REWARD", referencedColumnName="ID_REWARD")
     *   }
     * )
     */
    private $idReward;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Franchises", mappedBy="idUser")
     */
    private $idFranchise;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idAdresse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idReward = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idFranchise = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEuroPoints(): ?int
    {
        return $this->euroPoints;
    }

    public function setEuroPoints(?int $euroPoints): self
    {
        $this->euroPoints = $euroPoints;

        return $this;
    }

    public function getFormulePoints(): ?int
    {
        return $this->formulePoints;
    }

    public function setFormulePoints(?int $formulePoints): self
    {
        $this->formulePoints = $formulePoints;

        return $this;
    }

    public function getIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(?bool $isActivated): self
    {
        $this->isActivated = $isActivated;

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

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getIdRole(): ?Roles
    {
        return $this->idRole;
    }

    public function setIdRole(?Roles $idRole): self
    {
        $this->idRole = $idRole;

        return $this;
    }

    /**
     * @return Collection|Addresses[]
     */
    public function getIdAdresse(): Collection
    {
        return $this->idAdresse;
    }

    public function addIdAdresse(Addresses $idAdresse): self
    {
        if (!$this->idAdresse->contains($idAdresse)) {
            $this->idAdresse[] = $idAdresse;
            $idAdresse->addIdUser($this);
        }

        return $this;
    }

    public function removeIdAdresse(Addresses $idAdresse): self
    {
        if ($this->idAdresse->contains($idAdresse)) {
            $this->idAdresse->removeElement($idAdresse);
            $idAdresse->removeIdUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Rewards[]
     */
    public function getIdReward(): Collection
    {
        return $this->idReward;
    }

    public function addIdReward(Rewards $idReward): self
    {
        if (!$this->idReward->contains($idReward)) {
            $this->idReward[] = $idReward;
        }

        return $this;
    }

    public function removeIdReward(Rewards $idReward): self
    {
        if ($this->idReward->contains($idReward)) {
            $this->idReward->removeElement($idReward);
        }

        return $this;
    }

    /**
     * @return Collection|Franchises[]
     */
    public function getIdFranchise(): Collection
    {
        return $this->idFranchise;
    }

    public function addIdFranchise(Franchises $idFranchise): self
    {
        if (!$this->idFranchise->contains($idFranchise)) {
            $this->idFranchise[] = $idFranchise;
            $idFranchise->addIdUser($this);
        }

        return $this;
    }

    public function removeIdFranchise(Franchises $idFranchise): self
    {
        if ($this->idFranchise->contains($idFranchise)) {
            $this->idFranchise->removeElement($idFranchise);
            $idFranchise->removeIdUser($this);
        }

        return $this;
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
    return ['ROLE_ADMIN'];
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
