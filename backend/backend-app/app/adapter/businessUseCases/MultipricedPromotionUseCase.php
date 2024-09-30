<?php

namespace App\adapter\businessUseCases;


use App\Domain\Entities\Product;

/**
 * @implements UseCaseInterface<Product, float>
 */
class MultipricedPromotionUseCase
{
    /**
     * Execute the use case.
     *
     * @param array $input [Product, count, quantity required for promotion, discounted price]
     * @return float Total price with promotion applied
     */
    public function execute($input): float
    {
        [$product, $count, $quantityRequired, $discountedPrice] = $input;

        // Calculate the total cost with multipriced promotion
        $promotionSets = intdiv($count, $quantityRequired);  // Full sets of promotion
        $remainingItems = $count % $quantityRequired;  // Remaining items after promotion

        return ($promotionSets * $discountedPrice) + ($remainingItems * $product->getPrice());
    }
}
