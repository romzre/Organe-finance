<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Repository\CycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;
use App\Repository\TransactionRepository;


class ServiceDashboard extends AbstractService
{
    protected EntityManagerInterface $manager;
    private BankAccountRepository $BankAccountRepository;
    private CycleRepository $CycleRepository;

    private TransactionRepository $TransactionRepository;

    public function __construct(
        BankAccountRepository $BankAccountRepository, 
         CycleRepository $CycleRepository , 
         EntityManagerInterface $manager,
         TransactionRepository $TransactionRepository
         )
    {
        $this->manager = $manager;
        $this->BankAccountRepository = $BankAccountRepository;
        $this->CycleRepository = $CycleRepository;
        $this->TransactionRepository = $TransactionRepository;

    }

    public function getActiveBankAccounts(User $user): array
    {
        $BankAccounts = [];
        $BankAccounts = $this->BankAccountRepository->findBy(["user" => $user]);

        return $BankAccounts;
    }

    public function getDashboard(User $user, array $options)
    {
        $data = [];
        $data['BankAccounts'] =  $this->getActiveBankAccounts($user);

        if(!empty($options['BankAccountId']))
        {
            $BankAccount =  $this->getAccount($options['BankAccountId']);
            $Cycle =  $this->getActiveCycle($BankAccount);

            $data['BankAccount'] = $BankAccount;
            $data['Cycle'] = $Cycle;
        }
        if(!empty($options['TransactionId']))
        {
            $Transaction = $options['TransactionId'];
            $Cycle = $this->CycleRepository->findOneBy(['id' => $Transaction->getCycle()->getId()]);
            $BankAccount = $Cycle->getBankAccount();
            $data['Cycle'] = $Cycle;
            $data['BankAccount'] = $BankAccount;

        }

        if(!empty($options['CycleId']))
        {
          
            $Cycle = $options['CycleId'];
            $BankAccount = $Cycle->getBankAccount();
            $cycle = $this->getActiveCycle($BankAccount);
            $data['BankAccount'] = $BankAccount;
            $data['Cycle'] = $cycle;
            
        }
        return $data;
    }

    public function getSumEntries($BankAccount)
    {
        $Cycle = $this->getActiveCycle($BankAccount);
        $results = $this->TransactionRepository->getSumTotalInflow($Cycle);
        
        return implode("" , $results[0]);
    }

    public function getSumOuties($BankAccount)
    {
        $Cycle = $this->getActiveCycle($BankAccount);
        $results = $this->TransactionRepository->getSumTotalOutflow($Cycle);
        
        return implode("" , $results[0]);
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

}
