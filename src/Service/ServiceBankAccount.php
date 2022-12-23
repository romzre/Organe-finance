<?php

namespace App\Service;

use App\Entity\User;
use App\Service\Service;
use App\Entity\BankAccount;
use Symfony\Component\DomCrawler\Form;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;

class ServiceBankAccount extends Service
{
    protected EntityManagerInterface $manager;
    protected BankAccountRepository $repository;

    public function __construct(EntityManagerInterface $manager, BankAccountRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }


    public function addBankAccount($form , $user): void
    {
        $account = $form;
        $account->setCreatedAt(new \DateTimeImmutable())
                ->setIsActive(1)
                ->setUser($user);
        $this->manager->persist($account);
        $this->manager->flush();

    }

    // public function getAllActive(User $user): array
    // {
    //     return $this->repository->findBy(
    //         [
    //             'user' => $user
    //         ]
    //     );
    // }

    // public function getAccount(string $id) : BankAccount
    // {
    //     $account = $this->repository->findOneBy(['id' => $id]);

    //     return $account;
    // }

}