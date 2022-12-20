<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * 
 * @UniqueEntity(
 *      fields = {"email"},
 *      message = "L'email que vous avez indiqué est déja utilisé !"
 * )
 */
class User implements UserInterface 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message= "Ce champ ne peut pas être vide")
     * @Assert\Email(
     *     message = "Cette email n'est pas valide"
     * )
     */
    private $email;

     /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message= "Ce champ ne peut pas être vide")
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     * @Assert\EqualTo(
     *     propertyPath="confirm_password", message="Tu t'es gourré sur le mot de passe"
     * )
     */
    private $password;

    /**
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     * @Assert\NotBlank(message= "Ce champ ne peut pas être vide")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="4", minMessage="Votre mot de passe doit faire minimum {{ limit }} caractères")
     * @Assert\Length(max="12", maxMessage="Votre mot de passe doit faire maximum {{ limit }} caractères")
     * @Assert\NotBlank(message= "Ce champ ne peut pas être vide")
     */
    private $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private $AgreeTerms;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerify;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity=BankAccount::class, mappedBy="user", orphanRemoval=true)
     */
    private $bankAccounts;

    public function __construct()
    {
        $this->bankAccounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function isAgreeTerms(): ?bool
    {
        return $this->AgreeTerms;
    }

    public function setAgreeTerms(bool $AgreeTerms): self
    {
        $this->AgreeTerms = $AgreeTerms;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(){}
    public function eraseCredentials(){}

    public function isIsVerify(): ?bool
    {
        return $this->isVerify;
    }

    public function setIsVerify(bool $isVerify): self
    {
        $this->isVerify = $isVerify;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }


    /**
     * Get the value of confirm_password
     */ 
    public function getConfirm_password()
    {
        return $this->confirm_password;
    }

    /**
     * Set the value of confirm_password
     *
     * @return  self
     */ 
    public function setConfirm_password($confirm_password)
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    /**
     * @return Collection<int, BankAccount>
     */
    public function getBankAccounts(): Collection
    {
        return $this->bankAccounts;
    }

    public function addBankAccount(BankAccount $bankAccount): self
    {
        if (!$this->bankAccounts->contains($bankAccount)) {
            $this->bankAccounts[] = $bankAccount;
            $bankAccount->setUser($this);
        }

        return $this;
    }

    public function removeBankAccount(BankAccount $bankAccount): self
    {
        if ($this->bankAccounts->removeElement($bankAccount)) {
            // set the owning side to null (unless already changed)
            if ($bankAccount->getUser() === $this) {
                $bankAccount->setUser(null);
            }
        }

        return $this;
    }
}
