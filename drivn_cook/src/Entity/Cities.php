<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cities
 *
 * @ORM\Table(name="CITIES", indexes={@ORM\Index(name="FK_IS_ALSO_SITUATED_IN", columns={"ID_DEPARTMENT"})})
 * @ORM\Entity
 */
class Cities
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CITY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="POSTAL_NUMBER", type="string", length=5, nullable=true)
     */
    private $postalNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CITY", type="string", length=200, nullable=true)
     */
    private $city;

    /**
     * @var \Departments
     *
     * @ORM\ManyToOne(targetEntity="Departments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_DEPARTMENT", referencedColumnName="ID_DEPARTMENT")
     * })
     */
    private $idDepartment;

    public function getIdCity(): ?int
    {
        return $this->idCity;
    }

    public function getPostalNumber(): ?string
    {
        return $this->postalNumber;
    }

    public function setPostalNumber(?string $postalNumber): self
    {
        $this->postalNumber = $postalNumber;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getIdDepartment(): ?Departments
    {
        return $this->idDepartment;
    }

    public function setIdDepartment(?Departments $idDepartment): self
    {
        $this->idDepartment = $idDepartment;

        return $this;
    }


}
