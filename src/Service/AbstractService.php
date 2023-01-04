<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;


abstract class AbstractService 
{
    protected EntityManagerInterface $manager;
 
    
    /**
     * getManager
     * Acces manager
     * @return EntityManagerInterface
     */
    public function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
    
    /**
     * getAllBankAccountActive
     * get BankAccounts use by user
     * @param  mixed $user
     * @return array
     */
    public function getAllBankAccountActive(User $user): array
    {
        return $this->getManager()->getRepository(BankAccount::class)->findBy(
            [
                'user' => $user
            ]
        );
    } 
    
    /**
     * getAccount
     * 
     * @param  mixed $id
     * @return BankAccount
     */
    public function getAccount(BankAccount $id) : BankAccount

    {
        $account = $this->getManager()->getRepository(BankAccount::class)->findOneBy(['id' => $id]);

        return $account;
    }

    public function getActiveCycle($BankAccount): Cycle
    {
      
        $cycle = $this->manager->getRepository(cycle::class)->findOneBy([
            'isActive' => 1,
            'BankAccount' => $BankAccount
        ]);
        return !empty($cycle) ? $cycle : new Cycle();
    }

    public function getCycle(Cycle $cycle)
    {
        $cycle = $this->manager->getRepository(Cycle::class)->find([
            'id' => $cycle,
        ]);

        return $cycle;
    }


    public function getTransactionsByCycle(Cycle $cycle): array
    {
        return $this->getManager()->getRepository(Transaction::class)->findBy(
            [
                'Cycle' => $cycle

            ],
            [
                "dateTransaction" => "ASC"

            ]
        );
    } 

}