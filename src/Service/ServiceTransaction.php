<?php
namespace App\Service;

use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Service\AbstractService;
use App\Repository\CycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;


class ServiceTransaction extends AbstractService
{
    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager )
    {
        $this->manager = $manager;
    }

}