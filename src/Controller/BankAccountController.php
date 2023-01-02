<?php

namespace App\Controller;


use App\Entity\BankAccount;
use App\Service\ServiceDashboard;
use App\Service\Chart\ServiceChart;
use App\Service\ServiceBankAccount;
use App\Service\ServiceTransaction;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BankAccountController extends AbstractController
{
    /**
     * @Route("/bank/account/{BankAccountId}", name="app_bank_account")
     */

    public function index( 
        ServiceDashboard $serviceDashboard ,
        BankAccount $BankAccountId, 
        ServiceBankAccount $serviceBankAccount,
        ServiceTransaction $serviceTransaction,
        ServiceChart $serviceChart
        ): Response
    {
        $data = [];
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['BankAccountId' => $BankAccountId] );

        if(!empty($BankAccountsAndCycleDashboard['Cycle']))
        {
            $chart = $serviceChart->index($BankAccountsAndCycleDashboard['Cycle']);
            $data['chart'] = $chart;
        }
        $Entry = $serviceDashboard->getSumEntries($BankAccountId);
        $Out = $serviceDashboard->getSumOuties($BankAccountId);
    

        $data['Entry'] = $Entry;
        $data['Out'] = $Out;
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        $data["cycle"] = $BankAccountsAndCycleDashboard['Cycle'];
        
        return $this->render('bank_account/index.html.twig', $data);
    }
}
