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

    public function __construct(EntityManagerInterface $manager )
    {
        $this->manager = $manager;
    }

    public function add($form , Cycle $cycle )
    {
        $transaction = $form;
        $transaction->setCreatedAt(new \DateTimeImmutable())
                    ->setCycle($cycle);
        $this->manager->persist($transaction);
        $this->manager->flush();

    }

}