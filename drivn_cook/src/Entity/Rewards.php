<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rewards
 *
 * @ORM\Table(name="REWARDS")
 * @ORM\Entity
 */
class Rewards
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_REWARD", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReward;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var int|null
     *
     * @ORM\Column(name="MINIMAL_POINTS", type="integer", nullable=true)
     */
    private $minimalPoints;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="idReward")
     */
    private $idUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Menu", inversedBy="idReward")
     * @ORM\JoinTable(name="reward_contents",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_REWARD", referencedColumnName="ID_REWARD")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_MENU", referencedColumnName="ID_MENU")
     *   }
     * )
     */
    private $idMenu;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idMenu = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdReward(): ?int
    {
        return $this->idReward;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMinimalPoints(): ?int
    {
        return $this->minimalPoints;
    }

    public function setMinimalPoints(?int $minimalPoints): self
    {
        $this->minimalPoints = $minimalPoints;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(Users $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
            $idUser->addIdReward($this);
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): self
    {
        if ($this->idUser->contains($idUser)) {
            $this->idUser->removeElement($idUser);
            $idUser->removeIdReward($this);
        }

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getIdMenu(): Collection
    {
        return $this->idMenu;
    }

    public function addIdMenu(Menu $idMenu): self
    {
        if (!$this->idMenu->contains($idMenu)) {
            $this->idMenu[] = $idMenu;
        }

        return $this;
    }

    public function removeIdMenu(Menu $idMenu): self
    {
        if ($this->idMenu->contains($idMenu)) {
            $this->idMenu->removeElement($idMenu);
        }

        return $this;
    }

}
