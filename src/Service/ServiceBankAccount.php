<?php

namespace App\Service;

use App\Entity\User;
use App\Service\AbstractService;
use App\Entity\BankAccount;
use Symfony\Component\DomCrawler\Form;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BankAccountRepository;

class ServiceBankAccount extends AbstractService
{
    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function addBankAccount($form , User $user): void
    {
        $account = $form;
        $account->setCreatedAt(new \DateTimeImmutable())
                ->setIsActive(1)
                ->setUser($user);
        $this->manager->persist($account);
        $this->manager->flush();

    }

  

}