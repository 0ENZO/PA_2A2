<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Addresses
 *
 * @ORM\Table(name="ADDRESSES", indexes={@ORM\Index(name="FK_LOCATED_AT", columns={"ID_EVENT"}), @ORM\Index(name="FK_IS_SITUATED_IN", columns={"ID_CITY"})})
 * @ORM\Entity
 */
class Addresses
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_ADRESSE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="STREET", type="string", length=100, nullable=false)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="NUMBER", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NUMBER_COMPLEMENT", type="string", length=5, nullable=true)
     */
    private $numberComplement;

    /**
     * @var \Cities
     *
     * @ORM\ManyToOne(targetEntity="Cities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CITY", referencedColumnName="ID_CITY")
     * })
     */
    private $idCity;

    /**
     * @var \Events
     *
     * @ORM\ManyToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_EVENT", referencedColumnName="ID_EVENT")
     * })
     */
    private $idEvent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", inversedBy="idAdresse")
     * @ORM\JoinTable(name="also_live_at",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_ADRESSE", referencedColumnName="ID_ADRESSE")
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
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdAdresse(): ?int
    {
        return $this->idAdresse;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getNumberComplement(): ?string
    {
        return $this->numberComplement;
    }

    public function setNumberComplement(?string $numberComplement): self
    {
        $this->numberComplement = $numberComplement;

        return $this;
    }

    public function getIdCity(): ?Cities
    {
        return $this->idCity;
    }

    public function setIdCity(?Cities $idCity): self
    {
        $this->idCity = $idCity;

        return $this;
    }

    public function getIdEvent(): ?Events
    {
        return $this->idEvent;
    }

    public function setIdEvent(?Events $idEvent): self
    {
        $this->idEvent = $idEvent;

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
        return $this->number.' '.$this->street.', '.$this->getIdCity()->getPostalNumber().' '.$this->getIdCity()->getName();
    }
}
