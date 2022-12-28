<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     */
    private $sum;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTransaction;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Periodicity::class, inversedBy="transactions")
     */
    private $Periodicity;

    /**
     * @ORM\ManyToOne(targetEntity=WayTransaction::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $WayTransaction;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTransaction::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TypeTransaction;

    /**
     * @ORM\ManyToOne(targetEntity=Cycle::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Cycle;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="transactions")
     */
    private $Category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(\DateTimeInterface $dateTransaction): self
    {
        $this->dateTransaction = $dateTransaction;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPeriodicity(): ?Periodicity
    {
        return $this->Periodicity;
    }

    public function setPeriodicity(?Periodicity $Periodicity): self
    {
        $this->Periodicity = $Periodicity;

        return $this;
    }

    public function getWayTransaction(): ?WayTransaction
    {
        return $this->WayTransaction;
    }

    public function setWayTransaction(?WayTransaction $WayTransaction): self
    {
        $this->WayTransaction = $WayTransaction;

        return $this;
    }

    public function getTypeTransaction(): ?TypeTransaction
    {
        return $this->TypeTransaction;
    }

    public function setTypeTransaction(?TypeTransaction $TypeTransaction): self
    {
        $this->TypeTransaction = $TypeTransaction;

        return $this;
    }

    public function getCycle(): ?Cycle
    {
        return $this->Cycle;
    }

    public function setCycle(?Cycle $Cycle): self
    {
        $this->Cycle = $Cycle;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }
}
