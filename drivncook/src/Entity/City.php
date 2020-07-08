<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 * @UniqueEntity(fields={"name"}, message="Ce nom existe déjà.")
 * @UniqueEntity(fields={"postal_code"}, message="Ce code postal existe déjà.")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un nom  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre un nom  à 255 caractères maximum"
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=false,
     *     message="Vous ne pouvez pas mettre de chiffres dans ce champs"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotNull
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="5",
     *     minMessage="Vous devez mettre un code postal  à 5 chiffres minimum",
     *     max="5",
     *     maxMessage="Vous devez mettre un code postal  à 5 caractères maximum"
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouvez mettre que des chiffres dans ce champs"
     * )
     */
    private $postal_code;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="cities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="city")
     */
    private $addresses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
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

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(int $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setCity($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getCity() === $this) {
                $address->setCity(null);
            }
        }

        return $this;
    }
}
