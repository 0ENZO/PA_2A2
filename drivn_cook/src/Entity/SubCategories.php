<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubCategories
 *
 * @ORM\Table(name="SUB_CATEGORIES", indexes={@ORM\Index(name="FK_SUB_CATEGORIZED_BY", columns={"ID_CATEGORY"})})
 * @ORM\Entity
 */
class SubCategories
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_SUB_CATEGORY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSubCategory;

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

    /**
     * @var string
     *
     * @ORM\Column(name="IMAGE", type="text", length=65535, nullable=false)
     */
    private $image;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATEGORY", referencedColumnName="ID_CATEGORY")
     * })
     */
    private $idCategory;

    public function getIdSubCategory(): ?int
    {
        return $this->idSubCategory;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdCategory(): ?Categories
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Categories $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }


}
