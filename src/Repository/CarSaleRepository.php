<?php

namespace App\Repository;

use App\Entity\CarSale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CarSaleRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, CarSale::class);
    }

    /**
     * @return CarSale[]
     */
    public function findAllSales(): array{
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function getAllSales(): array{
        return $this->findAll(); 
    }
}
