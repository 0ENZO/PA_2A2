<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departments
 *
 * @ORM\Table(name="DEPARTMENTS")
 * @ORM\Entity
 */
class Departments
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_DEPARTMENT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDepartment;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=200, nullable=false)
     */
    private $name;

    public function getIdDepartment(): ?int
    {
        return $this->idDepartment;
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


}
