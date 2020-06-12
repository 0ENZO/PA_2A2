<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Categories
 *
 * @ORM\Table(name="CATEGORIES")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Categories
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CATEGORY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="NAMEFILE", type="string", length=250, nullable=true)
     */
    private $fileName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $description;

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


    public function getIdCategory(): ?int
    {
        return $this->idCategory;
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

//    public function getImage(): ?string
//    {
//        return $this->image;
//    }

    // Nouveau getter pour VichUploader
    public function getImage(): ?File {
        return $this->image;
    }

//    public function setImage(string $image): self
//    {
//        $this->image = $image;
//
//        return $this;
//    }


    // Nouveau setter pour VichUploaderBundle
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

    public function __toString()
    {
        return $this->name;
    }


    public function getFileName() : ?string {
        return $this->fileName;
    }

    public function setFileName(string $fileName) : void {
        $this->fileName = $fileName;
    }


}
