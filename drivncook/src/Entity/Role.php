<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @UniqueEntity(fields={"name"}, message="Un rôle ayant ce nom est déjà pris. Veuillez en sélectionner une autre")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un nom  à 0 caractère minimum",
     *     max="50",
     *     maxMessage="Vous devez mettre un nom  à 50 caractères maximum"
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="role")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Franchise::class, mappedBy="role")
     */
    private $franchises;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->franchises = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getRole() === $this) {
                $user->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Franchise[]
     */
    public function getFranchises(): Collection
    {
        return $this->franchises;
    }

    public function addFranchise(Franchise $franchise): self
    {
        if (!$this->franchises->contains($franchise)) {
            $this->franchises[] = $franchise;
            $franchise->setRole($this);
        }

        return $this;
    }

    public function removeFranchise(Franchise $franchise): self
    {
        if ($this->franchises->contains($franchise)) {
            $this->franchises->removeElement($franchise);
            // set the owning side to null (unless already changed)
            if ($franchise->getRole() === $this) {
                $franchise->setRole(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
