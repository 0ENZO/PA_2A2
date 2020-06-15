<?php

namespace App\Entity;

use App\Repository\CreditCardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditCardRepository::class)
 */
class CreditCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $cardNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $expirationDate;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $verificationCode;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="creditCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="creditCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $franchise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getVerificationCode(): ?string
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(string $verificationCode): self
    {
        $this->verificationCode = $verificationCode;

        return $this;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
