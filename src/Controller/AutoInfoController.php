<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AutoInfoController extends AbstractController{
    #[Route('/autoinfo', name: 'auto_info')]
    public function index(): Response{
        return $this->render('autoinfo.html.twig');
    }
}