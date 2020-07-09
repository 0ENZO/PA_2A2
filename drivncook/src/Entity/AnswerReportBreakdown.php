<?php

namespace App\Entity;

use App\Repository\AnswerReportBreakdownRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=AnswerReportBreakdownRepository::class)
 */
class AnswerReportBreakdown
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ReportBreakdown::class, inversedBy="answerReportBreakdowns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reportBreakdown;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="answerReportBreakdowns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     *  @Assert\DateTime()
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(
     *     "today UTC",
     *     message="La date ne peut pas être avant aujourd'hui"
     * )
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportBreakdown(): ?ReportBreakdown
    {
        return $this->reportBreakdown;
    }

    public function setReportBreakdown(?ReportBreakdown $reportBreakdown): self
    {
        $this->reportBreakdown = $reportBreakdown;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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
}
