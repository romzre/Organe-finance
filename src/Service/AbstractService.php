<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\BankAccount;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;


abstract class AbstractService 
{
    protected EntityManagerInterface $manager;
 

    public function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }

    public function getAllBankAccountActive(User $user): array
    {
        return $this->getManager()->getRepository(BankAccount::class)->findBy(
            [
                'user' => $user
            ]
        );
    } 

    public function getAccount(string $id) : BankAccount
    {
        $account = $this->getManager()->getRepository(BankAccount::class)->findOneBy(['id' => $id]);

        return $account;
    }



}