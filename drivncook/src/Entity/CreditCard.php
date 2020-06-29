<?php

namespace App\Entity;

use App\Repository\CreditCardRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CreditCardRepository::class)
 * @UniqueEntity(fields={"cardNumber"}, message="Cette carte bancaire existe déjà.")
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
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouver mettre ques des chiffres dans ce champs"
     * )
     * @Assert\Length(
     *     min="16",
     *     minMessage="Vous devez mettre un nombre à 16 chiffres, correspondant aux chiffres de votre carte bancaire",
     *     max="16",
     *     maxMessage="Vous devez mettre un nombre à 16 chiffres, correspondant aux chiffres de votre carte bancaire"
     * )
     */
    private $cardNumber;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual(
     *     "today UTC",
     *     message="Vous devez disposez d'une carte valide : La date limite maximum accepté étant celle d'aujourd'hui"
     * )
     */
    private $expirationDate;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouver mettre ques des chiffres dans ce champs"
     * )
     * @Assert\Length(
     *     min="3",
     *     minMessage="Vous devez mettre un nombre à 3 chiffres exactement, correspondant aux chiffres au dos de votre carte bancaire",
     *     max="3",
     *     maxMessage="Vous devez mettre un nombre à 3 chiffres exactement, correspondant aux chiffres au dos votre carte bancaire"
     * )
     */
    private $verificationCode;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z\s]*$/",
     *     match=true,
     *     message="Vous ne pouvez pas mettre de chiffres dans ce champs",
     *     normalizer="trim"
     * )
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="creditCards")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Franchise::class, inversedBy="creditCards")
     * @ORM\JoinColumn(nullable=true)
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
