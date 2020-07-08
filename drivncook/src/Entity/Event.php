<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"franchise", "name"}, message="Vous avez un nom d'event pour le franchisé.")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre une adressse  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre une adresse  à 255 caractères maximum"
     * )
     */
    private $completeAddress;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un nom d'event  à 0 caractère minimum",
     *     max="100",
     *     maxMessage="Vous devez mettre un nom d'event  à 100 caractères maximum"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(
     *     "today UTC",
     *     message="La date de début d'event ne peut pas être avant aujourd'hui"
     * )
     */
    private $dateBegin;

    /**
     * @ORM\Column(type="datetime")
     *  @Assert\DateTime()
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(
     *     propertyPath="dateBegin",
     *     message="La date de fin d'event ne peut pas être avant la date de début"
     * )
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="event_images", fileNameProperty="imageName")
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
     * @ORM\ManyToMany(targetEntity=Franchise::class, inversedBy="events")
     */
    private $franchise;

    public function __construct()
    {
        $this->franchise = new ArrayCollection();
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
        return $this->completeAddress;
    }

    /**
     * @param mixed $completeAddress
     */
    public function setCompleteAddress($completeAddress): void
    {
        $this->completeAddress = $completeAddress;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

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
     * @return Collection|Franchise[]
     */
    public function getFranchise(): Collection
    {
        return $this->franchise;
    }

    public function addFranchise(Franchise $franchise): self
    {
        if (!$this->franchise->contains($franchise)) {
            $this->franchise[] = $franchise;
        }

        return $this;
    }

    public function removeFranchise(Franchise $franchise): self
    {
        if ($this->franchise->contains($franchise)) {
            $this->franchise->removeElement($franchise);
        }

        return $this;
    }
}
