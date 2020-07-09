<?php

namespace App\Entity;

use App\Repository\BreakdownRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BreakdownRepository::class)
 * @UniqueEntity(fields={"statement"}, message="Ce statement existe déjà.")
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
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un statement  à 0 caractère minimum",
     *     max="100",
     *     maxMessage="Vous devez mettre un statement  à 100 caractères maximum"
     * )
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
