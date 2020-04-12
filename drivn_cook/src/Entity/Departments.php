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
     * @ORM\Column(name="DEPARTMENT", type="string", length=200, nullable=false)
     */
    private $department;

    public function getIdDepartment(): ?int
    {
        return $this->idDepartment;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }


}
