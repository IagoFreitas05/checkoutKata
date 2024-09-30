<?php

namespace App\stategies;

use App\business\entities\Product;

class BuyNGetOneFreePromotionStrategy implements PromotionStrategyInterface
{
    public function execute(Product $product, int $quantity, $data): float
    {
        $freeItems = intdiv($quantity, $data['required_quantity'] + 1);
        $paidItems = $quantity - $freeItems;

        return $paidItems * $product->getPrice();
    }
}
