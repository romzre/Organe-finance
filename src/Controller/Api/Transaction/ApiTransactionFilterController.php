<?php

namespace App\Controller\Api\Transaction;

use App\Service\ServiceTransaction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiTransactionFilterController extends AbstractController
{
    /**
     * @Route("/api/transaction/date", name="api_transaction_date" )
     */
    public function filter(SerializerInterface $serializer , Request $request, ServiceTransaction $serviceTransaction): Response
    {
        if(!$this->getUser())
        {
            http_response_code(405);
            return new Response($serializer->serialize(["message" => "Interdit connard"],  'json') , 403 ,
            [
                "Content-type" => "application/json"
            ]);

        }
        else
        {
            $start = $request->get("Start");
            $end  = $request->get("End");
            $dates = $serviceTransaction->getPeriod($start , $end);

            $transactions = $serviceTransaction->getTransactionsByCustomCycle($dates);
           

            return new Response($serializer->serialize($transactions,  'json' , ['groups' => ['transaction_index']]) , 200);
        }
    }
}
