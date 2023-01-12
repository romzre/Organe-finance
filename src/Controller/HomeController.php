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

}
