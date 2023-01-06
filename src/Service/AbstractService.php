<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;
use DateTime;

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

    public function getTransactionsByCurrentCycle(Cycle $cycle): array
    {
        $currentMonth = $this->getCurrentMonth();

        return $this->getManager()->getRepository(Transaction::class)
        ->createQueryBuilder('t')
        ->select('t')
        ->where('t.dateTransaction > :dateBeginMonth')
        ->setParameter('dateBeginMonth', $currentMonth["dateStartMonth"])
        ->andWhere('t.dateTransaction < :dateEndMonth')
        ->setParameter('dateEndMonth', $currentMonth["dateEndMonth"])
        ->getQuery()
        ->getResult();
       
    } 

    public function getCurrentMonth(): array
    {
        $date = new DateTime();
        $nbDayInCurrentMonth = date('t');
        $dateStartMonth = $date->format("Y-m-01 00:00:00");
        $dateEndMonth = $date->format("Y-m-{$nbDayInCurrentMonth} 00:00:00");
        return [
            "dateStartMonth" => $dateStartMonth,
            "dateEndMonth" => $dateEndMonth
        ];
    }

    public function getPeriod(string $start , string $end): array
    {
        
        return ["start" => (new DateTime($start))->format("Y-m-d 00:00:00"), 'end' => (new DateTime($end))->format("Y-m-d 00:00:00")];
    }

    public function getTransactionsByCustomCycle(array $dates): array
    {

        return $this->getManager()->getRepository(Transaction::class)
        ->createQueryBuilder('t')
        ->select('t' )
        ->innerJoin('App\Entity\WayTransaction' , "WayTransaction" , "WITH" , "WayTransaction.id = t.WayTransaction")
        ->where('t.dateTransaction > :dateBeginMonth')
        ->setParameter('dateBeginMonth', $dates["start"])
        ->andWhere('t.dateTransaction < :dateEndMonth')
        ->setParameter('dateEndMonth', $dates["end"])
        ->getQuery()
        ->getResult();
       
    } 

}