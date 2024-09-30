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
    /**
     * @param InputPromotionUseCase
     */
    public function execute($input): float
    {
        return $input->quantity * ($input->data['discounted_price'] / $input->data['quantity']);
    }
}
