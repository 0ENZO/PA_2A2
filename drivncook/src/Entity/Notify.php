<?php

namespace App\Entity;

use App\Repository\NotifyRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NotifyRepository::class)
 */
class Notify
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un titre  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre un titre à 255 caractères maximum"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un bootstrapColor  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre un bootstrapColor à 255 caractères maximum"
     * )
     */
    private $bootstrapColor;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="notice")
     */
    private $franchise;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @Assert\GreaterThanOrEqual(
     *     propertyPath="dateBegin",
     *     message="La date de fin d'event ne peut pas être avant la date de début"
     * )
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getBootstrapColor(): ?string
    {
        return $this->bootstrapColor;
    }

    public function setBootstrapColor(?string $bootstrapColor): self
    {
        $this->bootstrapColor = $bootstrapColor;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
