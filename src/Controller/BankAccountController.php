<?php

namespace App\Controller;

use App\Service\ServiceBankAccount;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class BankAccountController extends AbstractController
{
    /**
     * @Route("/bank/account/{BankAccount}", name="app_bank_account")
     */
    public function index(string $BankAccount, ServiceBankAccount $serviceBankAccount): Response
    {
        // BankAccount
        $bankAccounts = $serviceBankAccount->getAllBankAccountActive($this->getUser());

        $bankAccount = $serviceBankAccount->getAccount($BankAccount);

        if ($bankAccount->getUser() !== $this->getUser()) 
        {
           throw new AccessDeniedException();
        }

        return $this->render('bank_account/index.html.twig', [
            "bankAccounts" => $bankAccounts,
            "bankAccount" => $bankAccount,
        ]);
    }
}
