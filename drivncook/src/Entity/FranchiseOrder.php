<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\FranchiseOrderRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FranchiseOrderRepository::class)
 * @Vich\Uploadable
 */
class FranchiseOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="franchiseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $franchise;

    /**
     * @ORM\ManyToOne(targetEntity=Warehouse::class, inversedBy="franchiseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;

    /**
     * @ORM\OneToMany(targetEntity=FranchiseOrderContent::class, mappedBy="franchiseOrder")
     */
    private $franchiseOrderContents;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="message_document", fileNameProperty="documentName")
     * @Assert\Image(
     *  maxSize = "5M",
     *  mimeTypes={ "application/pdf", "audio/mpeg", "audio/x-wav", "audio/AMR" },
     *  mimeTypesMessage = "Ce format de document n'est pas autorisé"
     * )
     * @var File|null
     */
    private $documentFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $documentName;

    public function __construct()
    {
        $this->franchiseOrderContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

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

    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(?Warehouse $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * @return Collection|FranchiseOrderContent[]
     */
    public function getFranchiseOrderContents(): Collection
    {
        return $this->franchiseOrderContents;
    }

    public function addFranchiseOrderContent(FranchiseOrderContent $franchiseOrderContent): self
    {
        if (!$this->franchiseOrderContents->contains($franchiseOrderContent)) {
            $this->franchiseOrderContents[] = $franchiseOrderContent;
            $franchiseOrderContent->setFranchiseOrder($this);
        }

        return $this;
    }

    public function removeFranchiseOrderContent(FranchiseOrderContent $franchiseOrderContent): self
    {
        if ($this->franchiseOrderContents->contains($franchiseOrderContent)) {
            $this->franchiseOrderContents->removeElement($franchiseOrderContent);
            // set the owning side to null (unless already changed)
            if ($franchiseOrderContent->getFranchiseOrder() === $this) {
                $franchiseOrderContent->setFranchiseOrder(null);
            }
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $documentFile
     */
    public function setDocumentFile(?File $documentFile = null): void
    {
        $this->documentFile = $documentFile;

        if (null !== $documentFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    public function setDocumentName(?string $documentName): void
    {
        $this->documentName = $documentName;
    }

    public function getDocumentName(): ?string
    {
        return $this->documentName;
    }
}
