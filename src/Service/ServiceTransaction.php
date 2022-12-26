<?php
namespace App\Service;

use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Entity\Transaction;
use App\Service\AbstractService;
use App\Repository\CycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use DateTimeImmutable;

class ServiceTransaction extends AbstractService
{
    protected EntityManagerInterface $manager;
    private TransactionRepository $transactionRepository;

    public function __construct(EntityManagerInterface $manager, TransactionRepository $transactionRepository )
    {
        $this->manager = $manager;
        $this->transactionRepository = $transactionRepository;
    }

    public function add($form , Cycle $cycle )
    {
        $transaction = $form;
        $transaction->setCreatedAt(new \DateTimeImmutable())
                    ->setCycle($cycle);
        $this->manager->persist($transaction);
        $this->manager->flush();

    }

    public function editTransaction(Transaction $transaction): void
    {
        $this->manager->persist($transaction);
        $this->manager->flush();
        
    }
  

    public function delete(Transaction $transaction): void
    {
       
        $this->transactionRepository->remove($transaction, true);
        
    }
}