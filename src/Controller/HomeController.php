<?php

namespace App\Controller;

use App\Repository\CarsInventoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController{
    #[Route('/', name: 'home')]
    public function index(CarsInventoryRepository $carinventoryRepository, SessionInterface $session): Response{
        $cars = $carinventoryRepository->findAllOrderedByBrandModelColor();
        return $this->render('home.html.twig', [
            'cars' => $cars,
            'user' => $session->get('user')
        ]);
    }
}