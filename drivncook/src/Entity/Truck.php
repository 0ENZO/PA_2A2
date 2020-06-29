<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TruckRepository::class)
 */
class Truck
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complete_address;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $factoryDate;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="trucks")
     */
    private $franchise;

    /**
     * @ORM\ManyToOne(targetEntity=MaxCapacity::class, inversedBy="trucks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $maxCapacity;

    /**
     * @ORM\OneToMany(targetEntity=TechnicalControl::class, mappedBy="truck")
     */
    private $technicalControls;

    /**
     * @ORM\OneToMany(targetEntity=MaintenanceManual::class, mappedBy="truck")
     */
    private $maintenanceManuals;

    /**
     * @ORM\OneToMany(targetEntity=ReportBreakdown::class, mappedBy="truck")
     */
    private $reportBreakdowns;

    public function __construct()
    {
        $this->technicalControls = new ArrayCollection();
        $this->maintenanceManuals = new ArrayCollection();
        $this->reportBreakdowns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCompleteAddress()
    {
        return $this->complete_address;
    }

    /**
     * @param mixed $complete_address
     */
    public function setCompleteAddress($complete_address): void
    {
        $this->complete_address = $complete_address;
    }



    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFactoryDate(): ?\DateTimeInterface
    {
        return $this->factoryDate;
    }

    public function setFactoryDate(\DateTimeInterface $factoryDate): self
    {
        $this->factoryDate = $factoryDate;

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

    public function getMaxCapacity(): ?MaxCapacity
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(?MaxCapacity $maxCapacity): self
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    /**
     * @return Collection|TechnicalControl[]
     */
    public function getTechnicalControls(): Collection
    {
        return $this->technicalControls;
    }

    public function addTechnicalControl(TechnicalControl $technicalControl): self
    {
        if (!$this->technicalControls->contains($technicalControl)) {
            $this->technicalControls[] = $technicalControl;
            $technicalControl->setTruck($this);
        }

        return $this;
    }

    public function removeTechnicalControl(TechnicalControl $technicalControl): self
    {
        if ($this->technicalControls->contains($technicalControl)) {
            $this->technicalControls->removeElement($technicalControl);
            // set the owning side to null (unless already changed)
            if ($technicalControl->getTruck() === $this) {
                $technicalControl->setTruck(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MaintenanceManual[]
     */
    public function getMaintenanceManuals(): Collection
    {
        return $this->maintenanceManuals;
    }

    public function addMaintenanceManual(MaintenanceManual $maintenanceManual): self
    {
        if (!$this->maintenanceManuals->contains($maintenanceManual)) {
            $this->maintenanceManuals[] = $maintenanceManual;
            $maintenanceManual->setTruck($this);
        }

        return $this;
    }

    public function removeMaintenanceManual(MaintenanceManual $maintenanceManual): self
    {
        if ($this->maintenanceManuals->contains($maintenanceManual)) {
            $this->maintenanceManuals->removeElement($maintenanceManual);
            // set the owning side to null (unless already changed)
            if ($maintenanceManual->getTruck() === $this) {
                $maintenanceManual->setTruck(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->brand . $this->model;
    }

    /**
     * @return Collection|ReportBreakdown[]
     */
    public function getReportBreakdowns(): Collection
    {
        return $this->reportBreakdowns;
    }

    public function addReportBreakdown(ReportBreakdown $reportBreakdown): self
    {
        if (!$this->reportBreakdowns->contains($reportBreakdown)) {
            $this->reportBreakdowns[] = $reportBreakdown;
            $reportBreakdown->setTruck($this);
        }

        return $this;
    }

    public function removeReportBreakdown(ReportBreakdown $reportBreakdown): self
    {
        if ($this->reportBreakdowns->contains($reportBreakdown)) {
            $this->reportBreakdowns->removeElement($reportBreakdown);
            // set the owning side to null (unless already changed)
            if ($reportBreakdown->getTruck() === $this) {
                $reportBreakdown->setTruck(null);
            }
        }

        return $this;
    }
}
