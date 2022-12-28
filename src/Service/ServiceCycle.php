<?php

namespace App\Service;

use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Service\AbstractService;
use App\Repository\CycleRepository;
use Doctrine\ORM\EntityManagerInterface;


class ServiceCycle extends AbstractService
{
    protected EntityManagerInterface $manager;
    protected CycleRepository $repository;


    public function __construct(
        EntityManagerInterface $manager ,
        CycleRepository $repository
    )

    {
        $this->repository =  $repository;
        $this->manager = $manager;
    }

    
    /**
     * addCycle
     *
     * @param  mixed $form
     * @param  mixed $BankAccount
     * @return void
     */
    public function addCycle($form , BankAccount $BankAccount): void
    {
        $cycle = $form;
        $cycle->setCreatedAt(new \DateTimeImmutable())
                ->setIsActive(1)
                ->setBankAccount($BankAccount);
        $this->manager->persist($cycle);
        $this->manager->flush();
    }

    
    /**
     * checkIfCycleActiveExist
     *
     * @param  mixed $BankAccount
     * @return bool
     */
    public function checkIfCycleActiveExist($BankAccount): bool
    {
        $BankAccountActive = $this->manager->getRepository(Cycle::class)->findOneBy([
            'isActive' => 1,
            "BankAccount" => $BankAccount

        ]);

        return empty($BankAccountActive) ? false : true; 
    }

}