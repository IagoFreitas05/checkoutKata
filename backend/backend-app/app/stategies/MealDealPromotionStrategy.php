<?php

namespace App\stategies;

use App\business\entities\Product;

class MealDealPromotionStrategy implements PromotionStrategyInterface
{
    public function execute(Product $product, int $quantity, array $data): float
    {
        $total = 0;
        // Get the related product and its quantity from the $data array
        $relatedProductSku = $data['related_product_sku'];
        $relatedProductCount = $data['itemCounts'][$relatedProductSku] ?? 0;

        // Calculate the number of meal deal sets (min of both product and related product quantities)
        $mealSets = min($quantity, $relatedProductCount);

        // Apply the meal deal price for the full sets
        $total += $mealSets * $data['discounted_price']; // e.g., £3.00 for each D + E set

        // Calculate the remaining products that do not form a meal deal set
        $remainingMainProduct = $quantity - $mealSets;
        $remainingRelatedProduct = $relatedProductCount - $mealSets;

        // Add the remaining products to the total at their regular price
        $total += $remainingMainProduct * $product->getPrice(); // Regular price for remaining Product D
        $total += $remainingRelatedProduct * $data['related_product_price']; // Regular price for remaining Product E

        return $total;
    }
}
