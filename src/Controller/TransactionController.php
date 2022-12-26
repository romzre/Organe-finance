<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Entity\Transaction;
use App\Service\ServiceCycle;
use App\Form\TransactionFormType;
use App\Service\ServiceTransaction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionController extends AbstractController
{
    /**
     * @Route("/{CycleId}/transaction/new", name="app_transaction_new")
     */
    public function add(Cycle $CycleId , ServiceTransaction $serviceTransaction, Request $request , ServiceCycle $serviceCycle): Response
    {
        $data = [];

        $transaction = new Transaction();

        $form = $this->createForm(TransactionFormType::class , $transaction);
        $form->handleRequest($request);
        if ($form->isSubmitted()) 
        {
            if($form->isValid())
            {
            //    $cycle = $serviceCycle->getCycle($CycleId); 
               $serviceTransaction->add($form->getData(), $CycleId);
               $this->redirectToRoute('app_transaction_index', ["cycle" => $CycleId]);
            }
            else
            {
                $errors = $form->getErrors();
            }
        }

        // BankAccount
        $data["BankAccounts"] = $serviceTransaction->getAllBankAccountActive($this->getUser());
        $data['cycle'] = $serviceTransaction->getCycle($CycleId);
        $data['form'] = $form->createView();
 
        return $this->render('transaction/add.html.twig', $data);
    }

    /**
     * @Route("/{CycleId}/transaction", name="app_transaction_index")
     */
    public function index(Cycle $CycleId , ServiceTransaction $serviceTransaction, Request $request , ServiceCycle $serviceCycle): Response
    {
        $data = [];
        $transactions = $serviceTransaction->getTransactionsByCycle($CycleId);
    
        

        // BankAccount
        $data["BankAccounts"] = $serviceTransaction->getAllBankAccountActive($this->getUser());
        $data['cycle'] = $serviceTransaction->getCycle($CycleId);
        $data['transactions'] = $transactions;
        return $this->render('transaction/index.html.twig', $data);
    }
}
