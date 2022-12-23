<?php

namespace App\Entity;

use App\Repository\CycleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CycleRepository::class)
 */
class Cycle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\Range(
     *      min = "now", minMessage="Vous ne pouvez pas choisir une date antèrieur"
     * )
     */
    private $dateBegin;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\Range(
     *      minPropertyPath="dateBegin", minMessage="Vous ne pouvez pas choisir une date antèrieur à la date de début"
     * )
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="float")
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity=BankAccount::class, inversedBy="cycles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $BankAccount;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getBankAccount(): ?BankAccount
    {
        return $this->BankAccount;
    }

    public function setBankAccount(?BankAccount $BankAccount): self
    {
        $this->BankAccount = $BankAccount;

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
}
