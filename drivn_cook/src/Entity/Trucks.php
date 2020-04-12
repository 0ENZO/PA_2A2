<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trucks
 *
 * @ORM\Table(name="TRUCKS", indexes={@ORM\Index(name="FK_POSSESS", columns={"ID_FRANCHISE"}), @ORM\Index(name="FK_IS_ALSO_LIMITED", columns={"ID_MAX_CAPACITY"})})
 * @ORM\Entity
 */
class Trucks
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TRUCK", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTruck;

    /**
     * @var string
     *
     * @ORM\Column(name="BRAND", type="string", length=50, nullable=false)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="MODEL", type="string", length=50, nullable=false)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", length=50, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FACTORY_DATE", type="date", nullable=false)
     */
    private $factoryDate;

    /**
     * @var \MaxCapacities
     *
     * @ORM\ManyToOne(targetEntity="MaxCapacities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MAX_CAPACITY", referencedColumnName="ID_MAX_CAPACITY")
     * })
     */
    private $idMaxCapacity;

    /**
     * @var \Franchises
     *
     * @ORM\ManyToOne(targetEntity="Franchises")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FRANCHISE", referencedColumnName="ID_FRANCHISE")
     * })
     */
    private $idFranchise;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Breakdowns", inversedBy="idTruck")
     * @ORM\JoinTable(name="could_have",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_TRUCK", referencedColumnName="ID_TRUCK")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_BREAKDOWN", referencedColumnName="ID_BREAKDOWN")
     *   }
     * )
     */
    private $idBreakdown;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idBreakdown = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdTruck(): ?int
    {
        return $this->idTruck;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFactoryDate(): ?\DateTimeInterface
    {
        return $this->factoryDate;
    }

    public function setFactoryDate(\DateTimeInterface $factoryDate): self
    {
        $this->factoryDate = $factoryDate;

        return $this;
    }

    public function getIdMaxCapacity(): ?MaxCapacities
    {
        return $this->idMaxCapacity;
    }

    public function setIdMaxCapacity(?MaxCapacities $idMaxCapacity): self
    {
        $this->idMaxCapacity = $idMaxCapacity;

        return $this;
    }

    public function getIdFranchise(): ?Franchises
    {
        return $this->idFranchise;
    }

    public function setIdFranchise(?Franchises $idFranchise): self
    {
        $this->idFranchise = $idFranchise;

        return $this;
    }

    /**
     * @return Collection|Breakdowns[]
     */
    public function getIdBreakdown(): Collection
    {
        return $this->idBreakdown;
    }

    public function addIdBreakdown(Breakdowns $idBreakdown): self
    {
        if (!$this->idBreakdown->contains($idBreakdown)) {
            $this->idBreakdown[] = $idBreakdown;
        }

        return $this;
    }

    public function removeIdBreakdown(Breakdowns $idBreakdown): self
    {
        if ($this->idBreakdown->contains($idBreakdown)) {
            $this->idBreakdown->removeElement($idBreakdown);
        }

        return $this;
    }

}
