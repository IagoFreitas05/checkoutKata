<?php
namespace App\adapter\businessUseCases;


use App\Domain\Entities\Product;

/**
 * @implements UseCaseInterface<Product, float>
 */
class BuyNGetOneFreePromotionUseCase
{
    /**
     * Execute the use case.
     *
     * @param array $input [Product, count, required quantity for promotion]
     * @return float Total price with buy-n-get-one-free promotion applied
     */
    public function execute($input): float
    {
        [$product, $count, $requiredQuantity] = $input;

        // Calculate how many items are free
        $freeItems = intdiv($count, $requiredQuantity + 1);  // Number of free items
        $paidItems = $count - $freeItems;  // Items the customer pays for

        return $paidItems * $product->getPrice();
    }
}
