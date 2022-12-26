<?php

namespace App\Controller;

use App\Service\ServiceBankAccount;
use App\Service\ServiceDashboard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\TwigBundle\TwigBundle;



class BankAccountController extends AbstractController
{
    /**
     * @Route("/bank/account/{BankAccountId}", name="app_bank_account")
     */
    public function index( ServiceDashboard $serviceDashboard ,string $BankAccountId, ServiceBankAccount $serviceBankAccount): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['BankAccountId' => $BankAccountId] );
        
        
        $data = [];
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        $data["cycle"] = $BankAccountsAndCycleDashboard['Cycle'];
        
        return $this->render('bank_account/index.html.twig', $data);
    }
}
