<?php

namespace App\Service\BankAccount;

use App\Entity\User;
use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;


class BankAccountService extends AbstractService
{
    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getRepository()
    {
        return $this->manager->getRepository(BankAccount::class);
    }


    public function addBankAccount($form, User $user): BankAccount
    {
      
            $account = $form;
            $account->setCreatedAt(new \DateTimeImmutable())
                ->setIsActive(1)
                ->setUser($user);
            $this->manager->persist($account);
            $this->manager->flush();
           
            return $this->getRepository()->findOneBy(["id" => $account->getId()]);
       
    }


    // public function initBankAccount($form, User $user): array
    // {
    //     $data['BankAccount'] = $this->addBankAccount($form , $user);

    //     return [];
    // }
}
