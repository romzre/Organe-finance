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

class CycleController extends AbstractController
{
    /**
     * @Route("/{BankAccountId}/cycle", name="app_cycle_new")
     */
    public function index(ServiceDashboard $serviceDashboard, BankAccount $BankAccountId, ServiceCycle $service,  Request $request): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ['BankAccountId' => $BankAccountId]);
        // $bankAccounts = $service->getAllBankAccountActive($this->getUser());

        $data = [];
        $cycle = new Cycle();
        $form = $this->createForm(CycleAddFormType::class, $cycle);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($service->checkIfCycleActiveExist($BankAccountId)) {
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

        $data["CycleAddForm"] = $form->createView();
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
    
        return $this->render('cycle/add.html.twig', $data);
    }
}
