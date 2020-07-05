<?php

namespace App\Entity;

use App\Repository\UserOrderContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserOrderContentRepository::class)
 */
class UserOrderContent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=UserOrder::class, inversedBy="userOrderContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userOrder;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="userOrderContents")
     */
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserOrder(): ?UserOrder
    {
        return $this->userOrder;
    }

    public function setUserOrder(?UserOrder $userOrder): self
    {
        $this->userOrder = $userOrder;

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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
