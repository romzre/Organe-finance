<?php

namespace App\Service\Chart;

use App\Entity\Cycle;
use App\Entity\Transaction;
use App\Service\ServiceCycle;
use App\Service\AbstractService;
use App\Service\ServiceTransaction;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class ServiceChart extends AbstractService
{
    private ChartBuilderInterface $chartBuilder;
    private ServiceTransaction $serviceTransaction;

    public function __construct(ChartBuilderInterface $chartBuilder, ServiceTransaction $serviceTransaction)
    {
        $this->chartBuilder = $chartBuilder;
        $this->serviceTransaction = $serviceTransaction;
    }

    public function index(Cycle $cycle): Chart
    {

        $transactions = $this->serviceTransaction->getTransactionsByCycle($cycle);

        $categories = [];
        $colors = [];
        $transactionsSum = [];
        foreach ($transactions as $transaction) {
            if ($transaction->getTypeTransaction()->getLabel() === "Sortie") {
                $key = array_search($transaction->getCategory()->getLabel() , $categories);
                if(!empty($key))
                {
                    $transactionsSum[$key] += $transaction->getSum();
                }
                else
                {
                    $categories[] = $transaction->getCategory()->getLabel();
                    $transactionsSum[] = $transaction->getSum();
                    $colors[] = $transaction->getCategory()->getColor();
                }
            }
        }


        $chart = $this->chartBuilder->createChart(Chart::TYPE_DOUGHNUT);

        $chart->setData([

            'labels' => $categories,
            'datasets' => [
                [
                    'backgroundColor' => $colors,
                    'data' => $transactionsSum,
                    "hoverOffset" => 10,

                ],
            ],
        ]);

        $chart->setOptions([
            'title' => [
                'text' => "Répartition par catégorie",
            ],
            



        ]);

        return $chart;
    }
}
