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
            $input->relatedProductSku = $input->data['related_product_sku'] ?? null;
            $input->relatedProductPrice = $input->data['related_product_price'] ?? 0;
            $input->itemCounts = $input->data['itemCounts'] ?? [];
            $input->discountedPrice = $input->data['discounted_price'] ?? 0;

            // If related product SKU is not present, fallback to regular pricing
            if (!$input->relatedProductSku || !isset($input->itemCounts[$input->relatedProductSku])) {
                // Apply regular pricing
                return $input->product->getPrice() * $input->quantity;
            }

            // Calculate the count of related products available
            $relatedProductCount = $input->itemCounts[$input->relatedProductSku] ?? 0;

            // Calculate how many meal sets can be made
            $mealSets = min(intdiv($input->quantity, 1), $relatedProductCount); // 1 for 1-to-1

            // Apply the meal deal price for the full sets
            $total += $mealSets * $input->discountedPrice;

            // Calculate remaining products
            $remainingMainProduct = $input->quantity - $mealSets; // Main products left after sets
            $remainingRelatedProduct = $relatedProductCount - $mealSets; // Related products left after sets

            // Add the remaining main products at regular price
            $total += $remainingMainProduct * $input->product->getPrice();

            // Add the remaining related products at their regular price
            $total += $remainingRelatedProduct * $input->relatedProductPrice;

            return $total;
        }
    }
