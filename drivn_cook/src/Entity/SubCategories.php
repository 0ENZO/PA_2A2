<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * SubCategories
 *
 * @ORM\Table(name="SUB_CATEGORIES", indexes={@ORM\Index(name="FK_SUB_CATEGORIZED_BY", columns={"ID_CATEGORY"})})
 * @ORM\Entity
 * @Vich\Uploadable
 *
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
     * @var string
     *
     * @ORM\Column(name="NAMEFILE", type="string", length=250, nullable=true)
     */
    private $fileName;

    /**
     * @var File | null
     *
     * @Vich\UploadableField(mapping="categorie_images", fileNameProperty="fileName")
     */
    private $image;

    /**
     * @ORM\Column(name="UploadDate" ,type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $description;



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

    public function getIdCategory(): ?Categories
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Categories $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    public function getFileName() : ?string {
        return $this->fileName;
    }

    public function setFileName(string $fileName) : void {
        $this->fileName = $fileName;
    }

    public function __toString() : string {
        return $this->name;
    }

    public function getImage(): ?File {
        return $this->image;
    }

    /**
     * @param File|null $imageFile
     */
    public function setImage(?File $imageFile = null): void {
        $this->image = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }


}
