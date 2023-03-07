<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Service\ServiceDashboard;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BudgetController extends AbstractController
{
    /**
     * @Route("/budget/{CycleId}", name="app_budget_index")
     */
    public function index(Cycle $CycleId, ServiceDashboard $serviceDashboard ): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['CycleId' => $CycleId] );
        
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        $data["cycle"] = $BankAccountsAndCycleDashboard['Cycle'];

        return $this->render('budget/index.html.twig', $data);
    }

    /**
     *  @Route("/budget/ajouter")
     */
}
