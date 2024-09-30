<?php

namespace App\adapter\businessUseCases;




/**
 * @implements UseCaseInterface<array, float>
 */
class MealDealPromotionUseCase
{
    /**
     * Execute the meal deal promotion.
     *
     * @param array $input [
     *     'products' => array of Product instances in the cart,
     *     'promotion' => Promotion instance with related products for the meal deal
     * ]
     *
     * @return float The total price after applying the meal deal promotion
     */
    public function execute($input): float
    {
        // Extract the products and the promotion from the input
        $products = $input['products'];
        $promotion = $input['promotion'];

        // Get the main and related product involved in the meal deal
        $mainProduct = $promotion->product;
        $relatedProduct = $promotion->relatedProduct;

        // Get the SKUs of both products involved in the meal deal
        $mainProductSku = $mainProduct->sku;
        $relatedProductSku = $relatedProduct ? $relatedProduct->sku : null;

        // Count how many of each product is in the cart
        $mainProductCount = $products[$mainProductSku] ?? 0;
        $relatedProductCount = $products[$relatedProductSku] ?? 0;

        // Check how many full meal deal sets we can apply
        $mealSets = min($mainProductCount, $relatedProductCount);

        // Apply the meal deal for the number of sets
        $mealDealPrice = $mealSets * $promotion->discounted_price;

        // Calculate the price of remaining items not part of the meal deal
        $remainingMainProductPrice = ($mainProductCount - $mealSets) * $mainProduct->price;
        $remainingRelatedProductPrice = ($relatedProductCount - $mealSets) * $relatedProduct->price;

        // Total cost = meal deal price + price of remaining items
        return $mealDealPrice + $remainingMainProductPrice + $remainingRelatedProductPrice;
    }
}
