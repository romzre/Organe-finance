<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Entity\BankAccount;
use App\Service\ServiceCycle;
use App\Form\CycleAddFormType;
use App\Service\ServiceDashboard;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class CycleController extends AbstractController
{
    /**
     * @Route("/{BankAccountId}/cycle/new", name="app_cycle_new")
     */
    public function add(ServiceDashboard $serviceDashboard, BankAccount $BankAccountId, ServiceCycle $service,  Request $request): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['BankAccountId' => $BankAccountId]);
        $data = [];
        $cycle = new Cycle();
        $form = $this->createForm(CycleAddFormType::class, $cycle);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($service->checkIfCycleActiveExist($BankAccountId)) {
                    $service->disabledCycles($BankAccountId);
                    $service->addCycle($form->getData(), $BankAccountId);

                    $ActiveCycle = $service->getActiveCycle($BankAccountId);
                    $data["cycle"] = $ActiveCycle;
                } else {
                    $service->addCycle($form->getData(), $BankAccountId);
                    $data['message'] = $this->addFlash("success", "Votre cycle a bien été ajouter");
                    $ActiveCycle = $service->getActiveCycle($BankAccountId);
                    $data["cycle"] = $ActiveCycle;
                }
            }
        }
        $data['cycle'] = $BankAccountsAndCycleDashboard['Cycle'];
        $data["CycleAddForm"] = $form->createView();
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];

        return $this->render('cycle/add.html.twig', $data);
    }





    /**
     * @Route("/{BankAccountId}/cycle/", name="app_cycle_index")
     */
    public function index(ServiceDashboard $serviceDashboard, BankAccount $BankAccountId, ServiceCycle $service,  Request $request): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['BankAccountId' => $BankAccountId]);
        $cycles =  $service->getCycles($BankAccountId);
        
        $data = [];
        $data['cycles'] = $cycles;
        $data['cycle'] = $BankAccountsAndCycleDashboard['Cycle'];
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];

        return $this->render('cycle/index.html.twig', $data);
    }

    /**
     * @Route("/cycle/edit/{CycleId}", name="app_cycle_edit")
     */
    public function edit(ServiceDashboard $serviceDashboard, Cycle $CycleId, ServiceCycle $service,  Request $request): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['CycleId' => $CycleId]);
        $data = [];
        $cycle = $CycleId;
        $form = $this->createForm(CycleAddFormType::class, $cycle);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $service->disabledCycles($cycle->getBankAccount());
                $service->editCycle($form->getData());
                $data["cycle"] = $cycle;
                return $this->redirectToRoute("app_cycle_index", ["BankAccountId" => $BankAccountsAndCycleDashboard['BankAccount']->getId()]);
            } else {
                $data['error'] = $form->getErrors();
            }
        }


        $data["CycleAddForm"] = $form->createView();
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        return $this->render('cycle/add.html.twig', $data);
    }

    /**
     * @Route("/cycle/delete/{CycleId}", name="app_cycle_delete")
     */
    public function delete()
    {
    }

    /**
     * @Route("/cycle/active/{CycleId}", name="app_cycle_enabled")
     */
    public function enabled(Cycle $CycleId ,  ServiceCycle $service)
    {
        $service->enabledCycle($CycleId);
        return $this->redirectToRoute("app_cycle_index", ["BankAccountId" => $CycleId->getBankAccount()->getId()]);

    }
}
