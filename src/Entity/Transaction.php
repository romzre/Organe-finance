<?php

namespace App\Entity;

use App\Entity\Cycle;
use App\Entity\Category;
use App\Entity\Periodicity;
use App\Entity\WayTransaction;
use App\Entity\TypeTransaction;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("transaction_index")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("transaction_index")
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     * @Groups("transaction_index")
     */
    private $sum;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("transaction_index")
     */
    private $dateTransaction;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Periodicity::class, inversedBy="transactions")
     * 
     */
    private $Periodicity;

    /**
     * @ORM\ManyToOne(targetEntity=WayTransaction::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("transaction_index")
     */
    private $WayTransaction;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTransaction::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("transaction_index")
     */
    private $TypeTransaction;

    /**
     * @ORM\ManyToOne(targetEntity=Cycle::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Cycle;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="transactions")
     * @Groups("transaction_index")
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
