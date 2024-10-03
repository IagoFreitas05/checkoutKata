<?php
namespace App\adapter\businessUseCases;


use App\business\entities\Product;
use App\business\usecases\io\InputPromotionUseCase;

/**
 * @implements UseCaseInterface<Product, float>
 */
class BuyNGetOneFreePromotionImpl implements \App\business\usecases\BuyNGetOneFreePromotionUseCase
{
    /**
     * @param InputPromotionUseCase
     */
    public function execute($input): float
    {
        $freeItems = intdiv($input->quantity, $input->data['required_quantity'] + 1);
        $paidItems = $input->quantity - $freeItems;

        return $paidItems * $input->product->getPrice();
    }
}
