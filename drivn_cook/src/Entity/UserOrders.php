<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserOrders
 *
 * @ORM\Table(name="USER_ORDERS", indexes={@ORM\Index(name="FK_MAKE_USER_ORDER", columns={"ID_USER"})})
 * @ORM\Entity
 */
class UserOrders
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_USER_ORDER", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserOrder;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMMENT", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", length=50, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="BILL", type="text", length=65535, nullable=false)
     */
    private $bill;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Menu", mappedBy="idUserOrder")
     */
    private $idMenu;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idMenu = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdUserOrder(): ?int
    {
        return $this->idUserOrder;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBill(): ?string
    {
        return $this->bill;
    }

    public function setBill(string $bill): self
    {
        $this->bill = $bill;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

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
            $idMenu->addIdUserOrder($this);
        }

        return $this;
    }

    public function removeIdMenu(Menu $idMenu): self
    {
        if ($this->idMenu->contains($idMenu)) {
            $this->idMenu->removeElement($idMenu);
            $idMenu->removeIdUserOrder($this);
        }

        return $this;
    }

}
