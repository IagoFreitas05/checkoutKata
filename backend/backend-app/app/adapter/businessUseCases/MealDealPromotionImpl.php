<?php

namespace App\adapter\businessUseCases;


use App\business\entities\Product;
use App\business\usecases\io\InputPromotionUseCase;

/**
 * @implements UseCaseInterface<array, float>
 */
class MealDealPromotionImpl implements \App\business\usecases\MealDealPromotionUseCase
{
    /**
     * @param InputPromotionUseCase
     */
    public function execute($input): float
    {
        $total = 0;

        // Get the related product SKU and price from the data array
        $input->relatedProductSku = $data['related_product_sku'] ?? null;
        $input->relatedProductPrice = $data['related_product_price'] ?? 0;
        $input->itemCounts = $data['itemCounts'] ?? [];
        $input->discountedPrice = $data['discounted_price'] ?? 0;

        // If related product SKU is not present, fallback to regular pricing
        if (!$input->relatedProductSku || !isset($input->itemCounts[$input->relatedProductSku])) {
            // Apply regular pricing
            return $input->product->getPrice() * $input->quantity;
        }

        // Calculate meal deal sets and remaining products
        $relatedProductCount = $itemCounts[$input->relatedProductSku] ?? 0;
        $mealSets = min($input->quantity, $relatedProductCount);

        // Apply the meal deal price for the full sets
        $total += $mealSets * $input->discountedPrice;

        // Add remaining products that don't form a set at regular price
        $remainingMainProduct = $input->quantity - $mealSets;
        $remainingRelatedProduct = $relatedProductCount - $mealSets;

        $total += $remainingMainProduct * $input->product->getPrice();
        $total += $remainingRelatedProduct * $input->relatedProductPrice;

        return $total;
    }
}
