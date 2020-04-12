<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Breakdowns
 *
 * @ORM\Table(name="BREAKDOWNS", indexes={@ORM\Index(name="FK_SORTED_BY", columns={"ID_BREAKDOWN_TYPE"})})
 * @ORM\Entity
 */
class Breakdowns
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_BREAKDOWN", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBreakdown;

    /**
     * @var string|null
     *
     * @ORM\Column(name="STATEMENT", type="string", length=100, nullable=true)
     */
    private $statement;

    /**
     * @var \BreakdownTypes
     *
     * @ORM\ManyToOne(targetEntity="BreakdownTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_BREAKDOWN_TYPE", referencedColumnName="ID_BREAKDOWN_TYPE")
     * })
     */
    private $idBreakdownType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Trucks", mappedBy="idBreakdown")
     */
    private $idTruck;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idTruck = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdBreakdown(): ?int
    {
        return $this->idBreakdown;
    }

    public function getStatement(): ?string
    {
        return $this->statement;
    }

    public function setStatement(?string $statement): self
    {
        $this->statement = $statement;

        return $this;
    }

    public function getIdBreakdownType(): ?BreakdownTypes
    {
        return $this->idBreakdownType;
    }

    public function setIdBreakdownType(?BreakdownTypes $idBreakdownType): self
    {
        $this->idBreakdownType = $idBreakdownType;

        return $this;
    }

    /**
     * @return Collection|Trucks[]
     */
    public function getIdTruck(): Collection
    {
        return $this->idTruck;
    }

    public function addIdTruck(Trucks $idTruck): self
    {
        if (!$this->idTruck->contains($idTruck)) {
            $this->idTruck[] = $idTruck;
            $idTruck->addIdBreakdown($this);
        }

        return $this;
    }

    public function removeIdTruck(Trucks $idTruck): self
    {
        if ($this->idTruck->contains($idTruck)) {
            $this->idTruck->removeElement($idTruck);
            $idTruck->removeIdBreakdown($this);
        }

        return $this;
    }

}
