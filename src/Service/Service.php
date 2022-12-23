<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\BankAccount;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;


class Service 
{
    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager , BankAccountRepository $repositoryBankAccount)
    {
        $this->manager = $manager;
    }

    public function getAllBankAccountActive(User $user): array
    {
        return $this->manager->getRepository(BankAccount::class)->findBy(
            [
                'user' => $user
            ]
        );
    }

    public function getAccount(string $id) : BankAccount
    {
        $account = $this->manager->getRepository(BankAccount::class)->findOneBy(['id' => $id]);

        return $account;
    }

}