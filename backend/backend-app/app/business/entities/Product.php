<?php
// app/Domain/Entities/Product.php
namespace App\business\entities;

class Product
{
    private $sku;
    private $name;
    private $price;
    private $id;

    public function __construct(string $sku, string $name, int $price, int $id)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->id = $id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
