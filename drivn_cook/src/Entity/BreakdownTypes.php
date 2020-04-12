<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BreakdownTypes
 *
 * @ORM\Table(name="BREAKDOWN_TYPES")
 * @ORM\Entity
 */
class BreakdownTypes
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_BREAKDOWN_TYPE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBreakdownType;

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

    public function getIdBreakdownType(): ?int
    {
        return $this->idBreakdownType;
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


}
