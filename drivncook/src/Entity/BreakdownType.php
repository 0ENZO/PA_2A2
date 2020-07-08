<?php

namespace App\Entity;

use App\Repository\BreakdownTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BreakdownTypeRepository::class)
 * @UniqueEntity(fields={"name"}, message="Ce nom existe déjà.")
 * @UniqueEntity(fields={"description"}, message="Cette description existe déjà.")
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
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un nom  à 0 caractère minimum",
     *     max="100",
     *     maxMessage="Vous devez mettre un nom  à 50 caractères maximum"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
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

    public function __toString()
    {
        return $this->name;
    }
}
