<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReportBreakdownRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReportBreakdownRepository::class)
 * @Vich\Uploadable
 */
class ReportBreakdown
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Truck::class, inversedBy="reportBreakdowns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $truck;

    /**
     * @ORM\ManyToOne(targetEntity=Breakdown::class, inversedBy="reportBreakdowns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $breakdown;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Type(type="string")
     */
    private $phoneNumber;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="categorie_images", fileNameProperty="imageName")
     * @Assert\Image(
     *  maxSize = "5M",
     *  mimeTypes={ "image/gif", "image/jpeg", "image/png" }
     * )
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(name="UploadDate" ,type="datetime", nullable=true)
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=AnswerReportBreakdown::class, mappedBy="reportBreakdown")
     */
    private $answerReportBreakdowns;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    public function __construct()
    {
        $this->answerReportBreakdowns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(?Truck $truck): self
    {
        $this->truck = $truck;

        return $this;
    }

    public function getBreakdown(): ?Breakdown
    {
        return $this->breakdown;
    }

    public function setBreakdown(?Breakdown $breakdown): self
    {
        $this->breakdown = $breakdown;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection|AnswerReportBreakdown[]
     */
    public function getAnswerReportBreakdowns(): Collection
    {
        return $this->answerReportBreakdowns;
    }

    public function addAnswerReportBreakdown(AnswerReportBreakdown $answerReportBreakdown): self
    {
        if (!$this->answerReportBreakdowns->contains($answerReportBreakdown)) {
            $this->answerReportBreakdowns[] = $answerReportBreakdown;
            $answerReportBreakdown->setReportBreakdown($this);
        }

        return $this;
    }

    public function removeAnswerReportBreakdown(AnswerReportBreakdown $answerReportBreakdown): self
    {
        if ($this->answerReportBreakdowns->contains($answerReportBreakdown)) {
            $this->answerReportBreakdowns->removeElement($answerReportBreakdown);
            // set the owning side to null (unless already changed)
            if ($answerReportBreakdown->getReportBreakdown() === $this) {
                $answerReportBreakdown->setReportBreakdown(null);
            }
        }

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

    public function __toString()
    {
        // EA : a changer
        return $this->description;
    }
}
