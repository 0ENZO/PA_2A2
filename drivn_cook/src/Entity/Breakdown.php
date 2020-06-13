<?php

namespace App\Entity;

use App\Repository\BreakdownRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BreakdownRepository::class)
 */
class Breakdown
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $statement;

    /**
     * @ORM\ManyToOne(targetEntity=BreakdownType::class, inversedBy="breakdowns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $breakdownType;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBreakdownType(): ?BreakdownType
    {
        return $this->breakdownType;
    }

    public function setBreakdownType(?BreakdownType $breakdownType): self
    {
        $this->breakdownType = $breakdownType;

        return $this;
    }
}
