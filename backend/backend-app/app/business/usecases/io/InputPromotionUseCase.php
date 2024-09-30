<?php

namespace App\business\usecases\io;

use App\business\entities\Product;

class InputPromotionUseCase
{
    public Product $product;
    public int $quantity;
    public array $data;

    public function __construct(Product $product, int $quantity, array $data)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->data = $data;
    }
}
