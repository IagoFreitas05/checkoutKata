<?php

namespace App\stategies;

use App\business\entities\Product;

class MultipricedPromotionStrategy implements PromotionStrategyInterface
{
    public function execute(Product $product, int $quantity, $data): float
    {
        return $quantity * ($data['discounted_price'] / $data['quantity']);
    }
}
