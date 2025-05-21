<?php

namespace App\Controller;

use App\Repository\CarSaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaleTableController extends AbstractController{
    #[Route('/table', name: 'sales_table')]
    public function index(CarSaleRepository $carSaleRepository): Response{
        $sales = $carSaleRepository->findAllSales();
        return $this->render('saleTable.html.twig', [
            'sales' => $sales
        ]);
    }
}
