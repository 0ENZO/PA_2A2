<?php

namespace App\Entity;

use App\Repository\SaleRecordRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SaleRecordRepository::class)
 */
class SaleRecord
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(
     *     "today UTC",
     *     message="La date ne peut pas être avant aujourd'hui"
     * )
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(type="float")
     * @Assert\PositiveOrZero
     */
    private $totalExpenses;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(type="float")
     * @Assert\PositiveOrZero
     */
    private $totalRevenues;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(type="float")
     * @Assert\PositiveOrZero
     */
    private $totalProfits;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(type="float")
     * @Assert\PositiveOrZero
     */
    private $totalVat;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="saleRecords")
     * @ORM\JoinColumn(nullable=false)
     */
    private $franchise;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTotalExpenses(): ?float
    {
        return $this->totalExpenses;
    }

    public function setTotalExpenses(float $totalExpenses): self
    {
        $this->totalExpenses = $totalExpenses;

        return $this;
    }

    public function getTotalRevenues(): ?float
    {
        return $this->totalRevenues;
    }

    public function setTotalRevenues(?float $totalRevenues): self
    {
        $this->totalRevenues = $totalRevenues;

        return $this;
    }

    public function getTotalProfits(): ?float
    {
        return $this->totalProfits;
    }

    public function setTotalProfits(?float $totalProfits): self
    {
        $this->totalProfits = $totalProfits;

        return $this;
    }

    public function getTotalVat(): ?float
    {
        return $this->totalVat;
    }

    public function setTotalVat(?float $totalVat): self
    {
        $this->totalVat = $totalVat;

        return $this;
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
}
