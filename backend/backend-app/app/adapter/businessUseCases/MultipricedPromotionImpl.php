<?php

namespace App\adapter\businessUseCases;


use App\business\Entities\Product;
use App\business\usecases\io\InputPromotionUseCase;
use App\business\usecases\MultipricedPromotionUseCase;

/**
 * @implements MultipricedPromotionUseCase<Product, float>
 */
class MultipricedPromotionImpl implements MultipricedPromotionUseCase
{
    public function execute($input): float
    {
        $requiredQuantity = $input->data['quantity'];
        $discountedPrice = $input->data['discounted_price'];

        $pricePerItemDiscounted = $discountedPrice / $requiredQuantity;

        if ($input->quantity < $requiredQuantity) {
            return $input->quantity * $pricePerItemDiscounted;
        }

        $total = 0;

        $total += $requiredQuantity * $pricePerItemDiscounted;

        $remainingQuantity = $input->quantity - $requiredQuantity;

        $total += $remainingQuantity * ($input->data['regular_price'] ?? $pricePerItemDiscounted);

        return $total;
    }

}
