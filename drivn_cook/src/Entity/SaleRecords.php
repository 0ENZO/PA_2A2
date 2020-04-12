<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaleRecords
 *
 * @ORM\Table(name="SALE_RECORDS", indexes={@ORM\Index(name="FK_HAS", columns={"ID_FRANCHISE"})})
 * @ORM\Entity
 */
class SaleRecords
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_SALE_RECORD", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSaleRecord;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TOTAL_EXPENSES", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $totalExpenses;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TOTAL_REVENUES", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $totalRevenues;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TOTAL_PROFITS", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $totalProfits;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TOTAL_VAT", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $totalVat;

    /**
     * @var \Franchises
     *
     * @ORM\ManyToOne(targetEntity="Franchises")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FRANCHISE", referencedColumnName="ID_FRANCHISE")
     * })
     */
    private $idFranchise;

    public function getIdSaleRecord(): ?int
    {
        return $this->idSaleRecord;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalExpenses(): ?string
    {
        return $this->totalExpenses;
    }

    public function setTotalExpenses(?string $totalExpenses): self
    {
        $this->totalExpenses = $totalExpenses;

        return $this;
    }

    public function getTotalRevenues(): ?string
    {
        return $this->totalRevenues;
    }

    public function setTotalRevenues(?string $totalRevenues): self
    {
        $this->totalRevenues = $totalRevenues;

        return $this;
    }

    public function getTotalProfits(): ?string
    {
        return $this->totalProfits;
    }

    public function setTotalProfits(?string $totalProfits): self
    {
        $this->totalProfits = $totalProfits;

        return $this;
    }

    public function getTotalVat(): ?string
    {
        return $this->totalVat;
    }

    public function setTotalVat(?string $totalVat): self
    {
        $this->totalVat = $totalVat;

        return $this;
    }

    public function getIdFranchise(): ?Franchises
    {
        return $this->idFranchise;
    }

    public function setIdFranchise(?Franchises $idFranchise): self
    {
        $this->idFranchise = $idFranchise;

        return $this;
    }


}
