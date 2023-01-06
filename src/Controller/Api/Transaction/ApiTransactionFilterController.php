<?php

namespace App\Controller\Api\Transaction;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiTransactionFilterController extends AbstractController
{
    /**
     * @Route("/filter/transaction/{filter}", name="app_api_transaction_filter")
     */
    public function filter(SerializerInterface $serializer , string $filter): Response
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
            
            return new Response($serializer->serialize([$this->getUser()->getId() => "test"],  'json') , 200);
        }

    }

}
