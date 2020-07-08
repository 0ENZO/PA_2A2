<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 * @UniqueEntity(fields={"franchise", "name"}, message="Vous avez déjà créée un menu de ce genre, veuillez en faire un autre.")
 */
class Menu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="menus")
     */
    private $franchise;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un nom  à 0 caractère minimum",
     *     max="50",
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
     * @ORM\Column(type="float")
     * Assert\Type(type="float")
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     * Assert\Type(type="float")
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     */
    private $vat;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un statut  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre un statut à 255 caractères maximum"
     * )
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLocked;

    /**
     * @ORM\OneToMany(targetEntity=RewardContent::class, mappedBy="menu")
     */
    private $rewardContents;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="menus", orphanRemoval=true)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="menus")
     */
    private $subCategory;

    /**
     * @ORM\OneToMany(targetEntity=UserOrderContent::class, mappedBy="menu")
     */
    private $userOrderContents;

    public function __construct()
    {
        $this->rewardContents = new ArrayCollection();
        $this->article = new ArrayCollection();
        $this->userOrderContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFranchise(): ?Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(?Franchise $franchise): self
    {
        $this->franchise = $franchise;

        return $this;
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

    /**
     * @return Collection|RewardContent[]
     */
    public function getRewardContents(): Collection
    {
        return $this->rewardContents;
    }

    public function addRewardContent(RewardContent $rewardContent): self
    {
        if (!$this->rewardContents->contains($rewardContent)) {
            $this->rewardContents[] = $rewardContent;
            $rewardContent->setMenu($this);
        }

        return $this;
    }

    public function removeRewardContent(RewardContent $rewardContent): self
    {
        if ($this->rewardContents->contains($rewardContent)) {
            $this->rewardContents->removeElement($rewardContent);
            // set the owning side to null (unless already changed)
            if ($rewardContent->getMenu() === $this) {
                $rewardContent->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
        }

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
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }

    /**
     * @param mixed $isLocked
     */
    public function setIsLocked($isLocked): self
    {
        $this->isLocked = $isLocked;
        return $this;
    }

    public function __toString() : string {
        return $this->id." : ".$this->name."<br>";
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
     * @return Collection|UserOrderContent[]
     */
    public function getUserOrderContents(): Collection
    {
        return $this->userOrderContents;
    }

    public function addUserOrderContent(UserOrderContent $userOrderContent): self
    {
        if (!$this->userOrderContents->contains($userOrderContent)) {
            $this->userOrderContents[] = $userOrderContent;
            $userOrderContent->setMenu($this);
        }

        return $this;
    }

    public function removeUserOrderContent(UserOrderContent $userOrderContent): self
    {
        if ($this->userOrderContents->contains($userOrderContent)) {
            $this->userOrderContents->removeElement($userOrderContent);
            // set the owning side to null (unless already changed)
            if ($userOrderContent->getMenu() === $this) {
                $userOrderContent->setMenu(null);
            }
        }

        return $this;
    }

}
