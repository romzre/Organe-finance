<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Entity\Transaction;
use App\Form\TransactionFormType;
use App\Service\ServiceTransaction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionController extends AbstractController
{
    /**
     * @Route("/{CycleId}/transaction", name="app_transaction")
     */
    public function index(Cycle $CycleId , ServiceTransaction $serviceTransation): Response
    {
        $data = [];

        $transaction = new Transaction();

        $form = $this->createForm(TransactionFormType::class , $transaction);
        // BankAccount
        $data["BankAccounts"] = $serviceTransation->getAllBankAccountActive($this->getUser());
        $data['cycle'] = $serviceTransation->getCycle($CycleId);
        $data['form'] = $form->createView();
 
        return $this->render('transaction/index.html.twig', $data);
    }
}
