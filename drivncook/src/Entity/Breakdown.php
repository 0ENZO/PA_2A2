<?php

namespace App\Entity;

use App\Repository\BreakdownRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=ReportBreakdown::class, mappedBy="breakdown")
     */
    private $reportBreakdowns;

    public function __construct()
    {
        $this->reportBreakdowns = new ArrayCollection();
    }

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

    /**
     * @return Collection|ReportBreakdown[]
     */
    public function getReportBreakdowns(): Collection
    {
        return $this->reportBreakdowns;
    }

    public function addReportBreakdown(ReportBreakdown $reportBreakdown): self
    {
        if (!$this->reportBreakdowns->contains($reportBreakdown)) {
            $this->reportBreakdowns[] = $reportBreakdown;
            $reportBreakdown->setBreakdown($this);
        }

        return $this;
    }

    public function removeReportBreakdown(ReportBreakdown $reportBreakdown): self
    {
        if ($this->reportBreakdowns->contains($reportBreakdown)) {
            $this->reportBreakdowns->removeElement($reportBreakdown);
            // set the owning side to null (unless already changed)
            if ($reportBreakdown->getBreakdown() === $this) {
                $reportBreakdown->setBreakdown(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->statement;
    }
}
