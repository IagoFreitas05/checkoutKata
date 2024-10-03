<?php

namespace App\stategies;

use App\business\entities\Product;
use App\business\usecases\BuyNGetOneFreePromotionUseCase;
use App\business\usecases\io\InputPromotionUseCase;

class BuyNGetOneFreePromotionStrategy implements PromotionStrategyInterface
{
    private BuyNGetOneFreePromotionUseCase $useCase;

    public function __construct(BuyNGetOneFreePromotionUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function execute(Product $product, int $quantity, $data): float
    {
        return $this->useCase->execute(new InputPromotionUseCase($product, $quantity, $data));
    }
}
