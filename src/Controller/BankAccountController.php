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
     * @Route("/bank/account/{BankAccountId}", name="app_bank_account")
     */
    public function index(string $BankAccountId, ServiceBankAccount $serviceBankAccount): Response
    {
        $data = [];
        // BankAccount
        $data["BankAccounts"] = $serviceBankAccount->getAllBankAccountActive($this->getUser());
        $bankAccount = $serviceBankAccount->getAccount($BankAccountId);
        // Forbidden
        if ($bankAccount->getUser() !== $this->getUser()) 
        {
           throw new AccessDeniedException();
        }

        // Cycle
        $cycle = $serviceBankAccount->getActiveCycle($bankAccount);
        if(!empty($cycle))
        {
            $data['cycle'] = $cycle;
        }

        $data["BankAccount"] = $bankAccount;
        return $this->render('bank_account/index.html.twig', $data);
    }
}
