<?php

namespace App\Controller;

use App\Entity\BankAccount;
use App\Service\ServiceBankAccount;
use App\Form\AddBankAccountFormType;
use App\Service\ServiceDashboard;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

     /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard(ServiceDashboard $serviceDashboard ,Request $request , ServiceBankAccount $serviceBankAccount): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), []);

        $errors = [];
        $bankAccount = new BankAccount();
        
        $form = $this->createForm(AddBankAccountFormType::class , $bankAccount);
        $form->handleRequest($request);
        if ($form->isSubmitted()) 
        {
            if($form->isValid())
            {
                $serviceBankAccount->addBankAccount($form->getData(), $this->getUser());
            }
            else
            {
                $errors = $form->getErrors();
            }
        }

        $data = [];
        $data['errors'] = $errors;
        $data['BankAccounts'] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data['addBankAccountForm'] = $form->createView();
      
        return $this->render('dashboard/index.html.twig', $data );
    }

}
