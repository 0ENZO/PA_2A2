<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(
 *     fields={"name"},
 *     message="Cet article existe déjà dans notre base de données. Veuillez en choisir un autre."
 * )
 */
class Article
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
     * @Assert\Length(
     *     max="25",
     *     maxMessage="Vous ne pouvers pas mettre un nom d'artcile faisant plus de 25 caractères.",
     *     min="2",
     *     minMessage="Vous devez au moins mettre un nom d'article faisnt au moins 2 caractères."
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type(type="string")
     */ // Disponible ou indisponible, comme pour produit
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     */
    private $vat;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="articles")
     */
    private $subCategory;

    /**
     * @ORM\OneToMany(targetEntity=Recipe::class, mappedBy="article", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $recipes;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="article_images", fileNameProperty="imageName")
     * @Assert\Image(
     *  maxSize = "5M",
     *  mimeTypes={ "image/gif", "image/jpeg", "image/png" }
     * )
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(name="UploadDate" ,type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\ManyToMany(targetEntity=Menu::class, mappedBy="article")
     */
    private $menus;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->menus = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection|Recipe[]
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
            $recipe->setArticle($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->contains($recipe)) {
            $this->recipes->removeElement($recipe);
            // set the owning side to null (unless already changed)
            if ($recipe->getArticle() === $this) {
                $recipe->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }


    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addArticle($this);
        }

        return $this;
    }


    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            $menu->removeArticle($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
