<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CreditCards
 *
 * @ORM\Table(name="CREDIT_CARDS", indexes={@ORM\Index(name="FK_OWN", columns={"ID_USER"})})
 * @ORM\Entity
 */
class CreditCards
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CREDIT_CARD", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCreditCard;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CARD_NUMBER", type="string", length=16, nullable=true)
     */
    private $cardNumber;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="EXPIRATION_DATE", type="date", nullable=true)
     */
    private $expirationDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="VERIFICATION_CODE", type="string", length=3, nullable=true)
     */
    private $verificationCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;

    public function getIdCreditCard(): ?int
    {
        return $this->idCreditCard;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(?string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getVerificationCode(): ?string
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(?string $verificationCode): self
    {
        $this->verificationCode = $verificationCode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
