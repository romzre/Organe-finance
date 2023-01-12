<?php

namespace App\Service\Cycle;

use App\Entity\BankAccount;
use App\Entity\Cycle;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;

class CycleService extends AbstractService
{
    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getRepository()
    {
        return $this->manager->getRepository(Cycle::class);
    }

    public function addCycle(BankAccount $bankAccount , Float $solde): Cycle
    {
        $cycle = new Cycle();
        $cycle->setSolde($solde)
              ->setDateBegin(new \DateTimeImmutable())
              ->setIsActive(1)
              ->setBankAccount($bankAccount)
              ->setCreatedAt(new \DateTimeImmutable());

        $this->manager->persist($cycle);
        $this->manager->flush();
        return $this->getRepository()->findOneBy(["id" => $cycle->getId()]);
    }
}