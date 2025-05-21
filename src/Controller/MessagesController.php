<?php

namespace App\Controller;

use App\Entity\CarSale;
use App\Repository\CarsInventoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class MessagesController extends AbstractController{
    #[Route('/messages', name: 'messages', methods: ['POST'])]
    public function handleForm(Request $request,CarsInventoryRepository $carsInventoryRepository,EntityManagerInterface $entityManager): Response {
        $carBrand = $request->request->get('car_brand', '');
        $carModel = $request->request->get('car_model', '');
        $carColor = $request->request->get('car_color', '');
        $carPrice = $request->request->get('car_price', '');
        $clientName = $request->request->get('client_name', '');
        $clientPhone = $request->request->get('client_phone', '');
        $errors = [];

        if (empty($carBrand) || empty($carModel) || empty($carColor) || empty($carPrice)) {
            $errors[] = 'Все поля автомобиля должны быть заполнены.';
        }
        if (empty($clientName)) {
            $errors[] = 'Имя клиента обязательно.';
        }
        if (empty($clientPhone)) {
            $errors[] = 'Телефон клиента обязателен.';
        }
        if (!preg_match('/^[a-zA-Zа-яА-Я\s\-]+$/u', $clientName)) {
            $errors[] = 'Имя клиента может содержать только буквы, пробелы и дефисы.';
        }
        if (!preg_match('/^(\+7|8)\d{10}$/', $clientPhone)) {
            $errors[] = 'Телефон должен быть в формате +7XXXXXXXXXX или 8XXXXXXXXXX.';
        }

        $car = $carsInventoryRepository->findByCarDetails($carBrand, $carModel, $carColor, (float)$carPrice);
        if (!$car) {
            $errors[] = 'Выбранный автомобиль не найден в базе данных.';
        } elseif ($car->getStockQuantity() <= 0) {
            $errors[] = 'Выбранный автомобиль отсутствует на складе.';
        }
        if (!empty($errors)) {
            return $this->render('messages.html.twig', ['errors' => $errors]);
        }
        try {
            $carSale = new CarSale();
            $carSale->setCarBrand($carBrand);
            $carSale->setCarModel($carModel);
            $carSale->setCarColor($carColor);
            $carSale->setCarPrice((float)$carPrice);
            $carSale->setClientName($clientName);
            $carSale->setClientPhone($clientPhone);
            $entityManager->persist($carSale);
            $car->setStockQuantity($car->getStockQuantity() - 1);
            $entityManager->persist($car);
            $entityManager->flush();
            return $this->render('messages.html.twig', ['success' => 'Заказ успешно оформлен!']);
        } catch (\Exception $e) {
            return $this->render('messages.html.twig', ['errors' => ['Ошибка при обработке заказа: ' . $e->getMessage()]]);
        }
    }
}