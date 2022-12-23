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
        $bankAccounts = $service->getAllActive($this->getUser());

        $errors = [];
        $cycle = new Cycle();

        $form = $this->createForm(CycleAddFormType::class , $cycle);
        
        $form->handleRequest($request);

        return $this->render('cycle/add.html.twig', [
            'controller_name' => 'CycleController',
            "CycleAddForm" => $form->createView(),
            "bankAccounts" => $bankAccounts
        ]);
    }
}
