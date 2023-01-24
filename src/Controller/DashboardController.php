<?php

namespace App\Controller;

use App\Entity\BankAccount;
use App\Service\ServiceDashboard;
use App\Service\Cycle\CycleService;
use App\Form\AddBankAccountFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\BankAccount\BankAccountService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard" , name="app_dashboard")
     */
    public function dashboard(ServiceDashboard $serviceDashboard ,Request $request , BankAccountService $bankAccountService, CycleService $CycleService): Response
    {
        $data = [];
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), []);

        $form = $this->createForm(AddBankAccountFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $data['BankAccount'] = $bankAccountService->addBankAccount($form->getData(), $this->getUser());
            $data['Cycle'] = $CycleService->addCycle($data['BankAccount'] , floatval($form['solde']->getData())); 
            return $this->redirectToRoute('app_bank_account', ["BankAccountId" => $data['BankAccount']->getId()], Response::HTTP_SEE_OTHER);
        }
        $data['errors'] = $form->getErrors();
        $data['BankAccounts'] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data['addBankAccountForm'] = $form->createView();
      
        return $this->render('dashboard/index.html.twig', $data );

    }
}