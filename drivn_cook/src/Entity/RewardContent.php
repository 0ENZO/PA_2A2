<?php

namespace App\Entity;

use App\Repository\RewardContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RewardContentRepository::class)
 */
class RewardContent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Reward::class, inversedBy="rewardContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reward;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="rewardContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $menu;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReward(): ?Reward
    {
        return $this->reward;
    }

    public function setReward(?Reward $reward): self
    {
        $this->reward = $reward;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
