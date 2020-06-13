<?php

namespace App\Entity;

use App\Repository\BreakdownTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BreakdownTypeRepository::class)
 */
class BreakdownType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Breakdown::class, mappedBy="breakdownType")
     */
    private $breakdowns;

    public function __construct()
    {
        $this->breakdowns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Breakdown[]
     */
    public function getBreakdowns(): Collection
    {
        return $this->breakdowns;
    }

    public function addBreakdown(Breakdown $breakdown): self
    {
        if (!$this->breakdowns->contains($breakdown)) {
            $this->breakdowns[] = $breakdown;
            $breakdown->setBreakdownType($this);
        }

        return $this;
    }

    public function removeBreakdown(Breakdown $breakdown): self
    {
        if ($this->breakdowns->contains($breakdown)) {
            $this->breakdowns->removeElement($breakdown);
            // set the owning side to null (unless already changed)
            if ($breakdown->getBreakdownType() === $this) {
                $breakdown->setBreakdownType(null);
            }
        }

        return $this;
    }
}
