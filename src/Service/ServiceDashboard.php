<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\BankAccount;
use App\Repository\CycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;

class ServiceDashboard extends AbstractService
{
    protected EntityManagerInterface $manager;
    private BankAccountRepository $BankAccountRepository;
    private CycleRepository $CycleRepository;

    public function __construct(BankAccountRepository $BankAccountRepository, CycleRepository $CycleRepository , EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->BankAccountRepository = $BankAccountRepository;
        $this->CycleRepository = $CycleRepository;
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
        return $data;
    }

}
