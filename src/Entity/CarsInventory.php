<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cars_inventory')]
class CarsInventory{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $brand = null;
 
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $model = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $color = null;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private ?float $price = null;

    #[ORM\Column(type: 'integer')]
    private ?int $stockQuantity = null;

    public function getId(): ?int{return $this->id;}
    public function getBrand(): ?string{return $this->brand;}
    public function setBrand(string $brand): self{$this->brand = $brand;return $this;}
    public function getModel(): ?string{return $this->model;}
    public function setModel(string $model): self{$this->model = $model;return $this;}
    public function getColor(): ?string{return $this->color;}
    public function setColor(string $color): self{$this->color = $color;return $this;}
    public function getPrice(): ?float{return $this->price;}
    public function setPrice(float $price): self{$this->price = $price;return $this;}
    public function getStockQuantity(): ?int{return $this->stockQuantity;}
    public function setStockQuantity(int $stockQuantity): self{$this->stockQuantity = $stockQuantity;return $this;}
}
?>