<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="EVENTS")
 * @ORM\Entity
 */
class Events
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_EVENT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_BEGIN", type="date", nullable=false)
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_END", type="date", nullable=false)
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="PRICE", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Franchises", mappedBy="idEvent")
     */
    private $idFranchise;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idFranchise = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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
            $idFranchise->addIdEvent($this);
        }

        return $this;
    }

    public function removeIdFranchise(Franchises $idFranchise): self
    {
        if ($this->idFranchise->contains($idFranchise)) {
            $this->idFranchise->removeElement($idFranchise);
            $idFranchise->removeIdEvent($this);
        }

        return $this;
    }

}
