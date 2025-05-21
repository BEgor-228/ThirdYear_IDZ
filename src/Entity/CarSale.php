<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repository\CarSaleRepository::class)]
#[ORM\Table(name: 'carsales')]
class CarSale{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $carBrand = null;
    
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $carModel = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $carColor = null;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private ?float $carPrice = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $clientName = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $clientPhone = null;

    public function getId(): ?int{return $this->id;}
    public function getCarBrand(): ?string{ return $this->carBrand;}
    public function setCarBrand(string $carBrand): self{ $this->carBrand = $carBrand;return $this;}
    public function getCarModel(): ?string{return $this->carModel;}
    public function setCarModel(string $carModel): self{$this->carModel = $carModel;return $this;}
    public function getCarColor(): ?string{return $this->carColor;}
    public function setCarColor(string $carColor): self{$this->carColor = $carColor;return $this;}
    public function getCarPrice(): ?float{return $this->carPrice;}
    public function setCarPrice(float $carPrice): self{$this->carPrice = $carPrice;return $this;}
    public function getClientName(): ?string{return $this->clientName;}
    public function setClientName(string $clientName): self{$this->clientName = $clientName;return $this;}
    public function getClientPhone(): ?string{return $this->clientPhone;}
    public function setClientPhone(string $clientPhone): self{$this->clientPhone = $clientPhone;return $this;}
}