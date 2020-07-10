<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"email"}, message="Cette adresse email est déjà utilisée")
 *  @UniqueEntity(fields={"pseudo"}, message="Ce pseudo est déjà utilisé")
 *  @UniqueEntity(fields={"phoneNumber"}, message="Ce numéro est déjà utilisé")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     *  @Assert\Type(type="string")
     *  @Assert\NotNull
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un pseudo  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre un pseudo  à 30 caractères maximum"
     * )
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *  @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un prénom  à 0 caractère minimum",
     *     max="50",
     *     maxMessage="Vous devez mettre un prénom  à 50 caractères maximum"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un nom  à 0 caractère minimum",
     *     max="50",
     *     maxMessage="Vous devez mettre un nom  à 50 caractères maximum"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un email  à 0 caractère minimum",
     *     max="200",
     *     maxMessage="Vous devez mettre un email  à 200 caractères maximum"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     match=true,
     *     message="Vous ne pouvez mettre que des chiffres dans ce champs"
     * )
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *  @Assert\Type(type="int")
     * @Assert\PositiveOrZero
     */
    private $euroPoints;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="int")
     * @Assert\PositiveOrZero
     */
    private $formulePoints;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActivated;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un password  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre un password  à 255 caractères maximum"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="0",
     *     minMessage="Vous devez mettre un password  à 0 caractère minimum",
     *     max="255",
     *     maxMessage="Vous devez mettre un password  à 255 caractères maximum"
     * )
     */
    private $completeAddress;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThan(
     *     "today UTC",
     *     message="La date n'est pas valide"
     * )
     */
    private $birthDate;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="users")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=CreditCard::class, mappedBy="user")
     */
    private $creditCards;

    /**
     * @ORM\OneToMany(targetEntity=UserOrder::class, mappedBy="user")
     */
    private $userOrders;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="user")
     */
    private $votes;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="profile_images", fileNameProperty="imageName")
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
     * @ORM\ManyToMany(targetEntity=Reward::class, mappedBy="user")
     */
    private $rewards;

    /**
     * @ORM\OneToMany(targetEntity=AnswerReportBreakdown::class, mappedBy="user")
     */
    private $answerReportBreakdowns;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="editor")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=Notify::class, mappedBy="user")
     */
    private $notifies;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="users")
     */
    private $events;

    public function __construct()
    {
        $this->creditCards = new ArrayCollection();
        $this->userOrders = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->rewards = new ArrayCollection();
        $this->answerReportBreakdowns = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->notifies = new ArrayCollection();
        $this->events = new ArrayCollection();
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



    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEuroPoints(): ?int
    {
        return $this->euroPoints;
    }

    public function setEuroPoints(?int $euroPoints): self
    {
        $this->euroPoints = $euroPoints;

        return $this;
    }

    public function getFormulePoints(): ?int
    {
        return $this->formulePoints;
    }

    public function setFormulePoints(?int $formulePoints): self
    {
        $this->formulePoints = $formulePoints;

        return $this;
    }

    public function getIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(?bool $isActivated): self
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

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
     * @return Collection|CreditCard[]
     */
    public function getCreditCards(): Collection
    {
        return $this->creditCards;
    }

    public function addCreditCard(CreditCard $creditCard): self
    {
        if (!$this->creditCards->contains($creditCard)) {
            $this->creditCards[] = $creditCard;
            $creditCard->setUser($this);
        }

        return $this;
    }

    public function removeCreditCard(CreditCard $creditCard): self
    {
        if ($this->creditCards->contains($creditCard)) {
            $this->creditCards->removeElement($creditCard);
            // set the owning side to null (unless already changed)
            if ($creditCard->getUser() === $this) {
                $creditCard->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserOrder[]
     */
    public function getUserOrders(): Collection
    {
        return $this->userOrders;
    }

    public function addUserOrder(UserOrder $userOrder): self
    {
        if (!$this->userOrders->contains($userOrder)) {
            $this->userOrders[] = $userOrder;
            $userOrder->setUser($this);
        }

        return $this;
    }

    public function removeUserOrder(UserOrder $userOrder): self
    {
        if ($this->userOrders->contains($userOrder)) {
            $this->userOrders->removeElement($userOrder);
            // set the owning side to null (unless already changed)
            if ($userOrder->getUser() === $this) {
                $userOrder->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setUser($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getUser() === $this) {
                $vote->setUser(null);
            }
        }

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
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
    return $this->email;
    }

    /**
    * Returns the roles granted to the user.
    *
    *     public function getRoles()
    *     {
    *         return ['ROLE_USER'];
    *     }
    *
    * Alternatively, the roles might be stored on a ``roles`` property,
    * and populated in any number of different ways when the user object
    * is created.
    *
    * @return string[] The user roles
    */
    /*public function getRoles()
    {
        return str_split($this->role, 20);
    }*/

    /**
     * @see UserInterface
     */
    public function getRoles(): array{
        return str_split($this->role, 20);
    }

    /**
    * Returns the salt that was originally used to encode the password.
    *
    * This can return null if the password was not encoded using a salt.
    *
    * @return string|null The salt
    */
    public function getSalt()
    {
    return null;
    }

    /**
    * Removes sensitive data from the user.
    *
    * This is important if, at any given point, sensitive information like
    * the plain-text password is stored on this object.
    */
    public function eraseCredentials(){

    }

    public function __toString() : string {
        return $this->firstName." ".$this->lastName;
    }

    /**
     * @return Collection|Reward[]
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): self
    {
        if (!$this->rewards->contains($reward)) {
            $this->rewards[] = $reward;
            $reward->addUser($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): self
    {
        if ($this->rewards->contains($reward)) {
            $this->rewards->removeElement($reward);
            $reward->removeUser($this);
        }

        return $this;
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
            $answerReportBreakdown->setUser($this);
        }

        return $this;
    }

    public function removeAnswerReportBreakdown(AnswerReportBreakdown $answerReportBreakdown): self
    {
        if ($this->answerReportBreakdowns->contains($answerReportBreakdown)) {
            $this->answerReportBreakdowns->removeElement($answerReportBreakdown);
            // set the owning side to null (unless already changed)
            if ($answerReportBreakdown->getUser() === $this) {
                $answerReportBreakdown->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setEditor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getEditor() === $this) {
                $message->setEditor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notify[]
     */
    public function getNotifies(): Collection
    {
        return $this->notifies;
    }

    public function addNotify(Notify $notify): self
    {
        if (!$this->notifies->contains($notify)) {
            $this->notifies[] = $notify;
            $notify->setUser($this);
        }

        return $this;
    }

    public function removeNotify(Notify $notify): self
    {
        if ($this->notifies->contains($notify)) {
            $this->notifies->removeElement($notify);
            // set the owning side to null (unless already changed)
            if ($notify->getUser() === $this) {
                $notify->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addUser($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeUser($this);
        }

        return $this;
    }
}
