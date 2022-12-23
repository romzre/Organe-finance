<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Service\ServiceCycle;
use App\Form\CycleAddFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CycleController extends AbstractController
{
    /**
     * @Route("/{BankAccount}/cycle", name="app_cycle_new")
     */
    public function index(BankAccount $BankAccount, ServiceCycle $service ,  Request $request): Response
    {
        $bankAccounts = $service->getAllBankAccountActive($this->getUser());

        $errors = [];
        $message = '';
        $cycle = new Cycle();

        $form = $this->createForm(CycleAddFormType::class , $cycle);
        
        $form->handleRequest($request);

        if ($form->isSubmitted()) 
        {
            if($form->isValid())
            {
                $service->addCycle($form->getData(), $BankAccount);
                $message = $this->addFlash("success", "Votre cycle a bien été ajouter");
            }
            else
            {
                $errors = $form->getErrors();
                $message = $this->addFlash("error", "Une erreur est survenu. Veuillez réessayer");
            }
        }
        // dd($message);
        return $this->render('cycle/add.html.twig', [
            "CycleAddForm" => $form->createView(),
            "bankAccounts" => $bankAccounts,
            "errors" => $errors,
            "message" => $message
        ]);
    }
}
