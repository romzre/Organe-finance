<?php

namespace App\Service;

use App\Entity\BankAccount;
use App\Entity\User;
use App\Repository\BankAccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Form;

class ServiceBankAccount
{
    private EntityManagerInterface $manager;
    private BankAccountRepository $repository;

    public function __construct(EntityManagerInterface $manager , BankAccountRepository $repository)
    {
        $this->manager =  $manager;
        $this->repository =  $repository;

    }


    public function addBankAccount($form , User $user): void
    {
        $account = $form;
        $account->setCreatedAt(new \DateTimeImmutable())
                ->setUser($user);

        $this->manager->persist($account);
        $this->manager->flush();

    }

    public function getAllActive(): array
    {
        return $this->repository->findAll();
    }


}