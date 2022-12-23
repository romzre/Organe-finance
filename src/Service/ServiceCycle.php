<?php

namespace App\Service;

use App\Entity\Cycle;
use App\Repository\CycleRepository;
use Doctrine\ORM\EntityManagerInterface;


class ServiceCycle extends Service
{
    protected EntityManagerInterface $manager;
    protected CycleRepository $repository;

    public function __construct(EntityManagerInterface $manager , CycleRepository $repository)
    {
        $this->manager =  $manager;
        $this->repository =  $repository;

    }



}