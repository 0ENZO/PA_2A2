<?php

namespace App\Entity;

use App\Repository\RewardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RewardRepository::class)
 */
class Reward
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
     * @ORM\Column(type="string", length=11)
     */
    private $minimalPoints;

    /**
     * @ORM\OneToMany(targetEntity=RewardContent::class, mappedBy="reward")
     */
    private $rewardContents;

    public function __construct()
    {
        $this->rewardContents = new ArrayCollection();
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

    public function getMinimalPoints(): ?string
    {
        return $this->minimalPoints;
    }

    public function setMinimalPoints(string $minimalPoints): self
    {
        $this->minimalPoints = $minimalPoints;

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
            $rewardContent->setReward($this);
        }

        return $this;
    }

    public function removeRewardContent(RewardContent $rewardContent): self
    {
        if ($this->rewardContents->contains($rewardContent)) {
            $this->rewardContents->removeElement($rewardContent);
            // set the owning side to null (unless already changed)
            if ($rewardContent->getReward() === $this) {
                $rewardContent->setReward(null);
            }
        }

        return $this;
    }
}
