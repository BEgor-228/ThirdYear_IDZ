<?php

namespace App\Repository;

use App\Entity\CarsInventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CarsInventoryRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, CarsInventory::class);
    }
    public function findByCarDetails(string $brand, string $model, string $color, float $price): ?CarsInventory{
        return $this->createQueryBuilder('c')
            ->andWhere('c.brand = :brand')
            ->andWhere('c.model = :model')
            ->andWhere('c.color = :color')
            ->andWhere('c.price = :price')
            ->setParameter('brand', $brand)
            ->setParameter('model', $model)
            ->setParameter('color', $color)
            ->setParameter('price', $price)
            ->getQuery()
            ->getOneOrNullResult();
    }
    /**
     * @return CarsInventory[]
     */
    public function findAllOrderedByBrandModelColor(): array{
        return $this->createQueryBuilder('car')
            ->orderBy('car.brand', 'ASC')
            ->addOrderBy('car.model', 'ASC')
            ->addOrderBy('car.color', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
