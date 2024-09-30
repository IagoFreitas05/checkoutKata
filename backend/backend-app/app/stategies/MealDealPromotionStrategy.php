<?php

namespace App\stategies;

use App\business\entities\Product;

class MealDealPromotionStrategy implements PromotionStrategyInterface
{
    public function execute(Product $product, int $quantity, array $data): float
    {
        $total = 0;

        // Get the related product SKU and price from the data array
        $relatedProductSku = $data['related_product_sku'] ?? null;
        $relatedProductPrice = $data['related_product_price'] ?? 0;
        $itemCounts = $data['itemCounts'] ?? [];
        $discountedPrice = $data['discounted_price'] ?? 0;

        // If related product SKU is not present, fallback to regular pricing
        if (!$relatedProductSku || !isset($itemCounts[$relatedProductSku])) {
            // Apply regular pricing
            return $product->getPrice() * $quantity;
        }

        // Calculate meal deal sets and remaining products
        $relatedProductCount = $itemCounts[$relatedProductSku] ?? 0;
        $mealSets = min($quantity, $relatedProductCount);

        // Apply the meal deal price for the full sets
        $total += $mealSets * $discountedPrice;

        // Add remaining products that don't form a set at regular price
        $remainingMainProduct = $quantity - $mealSets;
        $remainingRelatedProduct = $relatedProductCount - $mealSets;

        $total += $remainingMainProduct * $product->getPrice();
        $total += $remainingRelatedProduct * $relatedProductPrice;

        return $total;
    }
}
