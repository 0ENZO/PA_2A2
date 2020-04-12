<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TechnicalControls
 *
 * @ORM\Table(name="TECHNICAL_CONTROLS", indexes={@ORM\Index(name="FK_CAN_HAVE", columns={"ID_TRUCK"})})
 * @ORM\Entity
 */
class TechnicalControls
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TECHNICAL_CONTROL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTechnicalControl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PICTURE", type="text", length=65535, nullable=true)
     */
    private $picture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMMENT", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \Trucks
     *
     * @ORM\ManyToOne(targetEntity="Trucks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_TRUCK", referencedColumnName="ID_TRUCK")
     * })
     */
    private $idTruck;

    public function getIdTechnicalControl(): ?int
    {
        return $this->idTechnicalControl;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIdTruck(): ?Trucks
    {
        return $this->idTruck;
    }

    public function setIdTruck(?Trucks $idTruck): self
    {
        $this->idTruck = $idTruck;

        return $this;
    }


}
