<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Entity\Transaction;
use App\Service\ServiceCycle;
use App\Form\TransactionFormType;
use App\Service\ServiceDashboard;
use App\Service\ServiceTransaction;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class TransactionController extends AbstractController
{
    /**
     * @Route("/{CycleId}/transaction/new", name="app_transaction_new")
     */

    public function add(ServiceDashboard $serviceDashboard ,Cycle $CycleId , ServiceTransaction $serviceTransaction, Request $request , ServiceCycle $serviceCycle): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['CycleId' => $CycleId]);

        $data = [];

        $transaction = new Transaction();

        $form = $this->createForm(TransactionFormType::class , $transaction);
        $form->handleRequest($request);
        if ($form->isSubmitted()) 
        {
            if($form->isValid())
            {
               $serviceTransaction->add($form->getData(), $CycleId);


            }
            else
            {
                $errors = $form->getErrors();
            }
            return $this->redirectToRoute('app_transaction_index', ["CycleId" => $CycleId->getId()], 302);
        }

        // BankAccount
        $data['cycle'] = $BankAccountsAndCycleDashboard['Cycle'];
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        $data['form'] = $form->createView();
 
        return $this->render('transaction/add.html.twig', $data);
    }

    /**
     * @Route("/{CycleId}/transaction", name="app_transaction_index")
     */

    public function index(ServiceDashboard $serviceDashboard, Cycle $CycleId , ServiceTransaction $serviceTransaction, Request $request , ServiceCycle $serviceCycle): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['CycleId' => $CycleId]);
        $data = [];
        $transactions = $serviceTransaction->getTransactionsByCurrentCycle($CycleId, ['page' => $request->query->getInt('page', 1)]);

        $Entry = $serviceDashboard->getSumEntries($BankAccountsAndCycleDashboard['BankAccount']);
        $Out = $serviceDashboard->getSumOuties($BankAccountsAndCycleDashboard['BankAccount']);
    

        $data['Entry'] = $Entry;
        $data['Out'] = $Out;
        
        // BankAccount
        $data['cycle'] = $BankAccountsAndCycleDashboard['Cycle'];
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        
        $data['transactions'] = $transactions["transactions"];
        $data['pagination'] = ["pages" => $transactions['pages'], 
                                "page" => $transactions['page'], 
                                "limit" => $transactions['limit']];
        $data['dates'] = $serviceTransaction->getCurrentMonth();
        
        return $this->render('transaction/index.html.twig', $data);
    }

     /**
     * @Route("/transaction/edit/{TransactionId}", name="app_transaction_edit")
     */
    public function edit(Transaction $TransactionId , ServiceTransaction $serviceTransaction, ServiceDashboard $serviceDashboard, Request $request)
    {
        $data = [];

        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['TransactionId' => $TransactionId] );
        $cycle = $BankAccountsAndCycleDashboard['Cycle'];
        $data['transaction'] = $TransactionId;
        $form = $this->createForm(TransactionFormType::class , $TransactionId);
        $form->handleRequest($request);
        if ($form->isSubmitted()) 
        {
            if($form->isValid())
            {
               $serviceTransaction->editTransaction($form->getData());
               return $this->redirectToRoute('app_transaction_index', ["CycleId" => $cycle->getId()], 302);
            }
        }
        
        $data['form'] = $form->createView();
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        $data["cycle"] = $BankAccountsAndCycleDashboard['Cycle'];
        return $this->render('transaction/edit.html.twig', $data);
    }


     /**
     * @Route("/transaction/delete/{TransactionId}", name="app_transaction_delete")
     */
    public function delete(Transaction $TransactionId , ServiceTransaction $serviceTransaction)
    {   

        $serviceTransaction->delete($TransactionId);
        $cycle = $TransactionId->getCycle();

        return $this->redirectToRoute('app_transaction_index', ["CycleId" => $cycle->getId()], 302);
    }
}
