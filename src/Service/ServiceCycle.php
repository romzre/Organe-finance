<?php

namespace App\Service;


use DateTime;
use App\Entity\Cycle;
use DateTimeImmutable;
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
     * addCycleCustom
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

    public function editCycle($form): void
    {
        $cycle = $form;
        $cycle->setisActive(1);

        $this->manager->persist($cycle);
        $this->manager->flush();
        

    }
    
    public function getCycles(BankAccount $BankAccount): array
    {
        return $this->repository->findBy(["BankAccount" => $BankAccount]);
    }

    public function getActiveCycles(BankAccount $BankAccount): array
    {
        return $this->repository->findBy(["BankAccount" => $BankAccount , "isActive" => 1]);
    }

    /**
     * checkIfCycleActiveExist
     *
     * @param  mixed $BankAccount
     * @return bool
     */
    public function checkIfCycleActiveExist($BankAccount): bool
    {
        $BankAccountActive = $this->manager->getRepository(Cycle::class)->findBy([
            'isActive' => 1,
            "BankAccount" => $BankAccount

        ]);

        return empty($BankAccountActive) ? false : true; 
    }

    public function disabledCycles(BankAccount $bankAccount): void
    {
        $checkCycleActive = $this->checkIfCycleActiveExist($bankAccount);
        if($checkCycleActive)
        {
            $Cycles = $this->getActiveCycles($bankAccount);
            foreach ($Cycles as $cycle) {
                $cycle->setisActive(0);
            }
            $this->manager->flush();
        }
    }

    public function enabledCycle(Cycle $cycle): void
    {
        $this->disabledCycles($cycle->getBankAccount());
        $cycle->setIsActive(1);
        $this->manager->flush();
    }



}