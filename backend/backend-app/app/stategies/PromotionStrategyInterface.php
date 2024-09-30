<?php
// app/Application/Strategies/PromotionsStrategyInterface.php
namespace App\stategies;

use App\business\entities\Product;



interface PromotionStrategyInterface
{
    /**
     * @param Product $product The product involved in the promotion.
     * @param int $quantity The quantity of the product being purchased.
     * @param array $data Additional promotion-specific data (e.g., related products for meal deal).
     * @return float The calculated discount or total.
     */
    public function execute(Product $product, int $quantity, array $data): float;
}
