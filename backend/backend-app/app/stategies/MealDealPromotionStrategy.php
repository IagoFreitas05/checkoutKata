<?php

namespace App\stategies;

use App\business\entities\Product;
use App\business\usecases\io\InputPromotionUseCase;
use App\business\usecases\MealDealPromotionUseCase;

class MealDealPromotionStrategy implements PromotionStrategyInterface
{
    private MealDealPromotionUseCase $useCase;

    public function __construct(MealDealPromotionUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function execute(Product $product, int $quantity, array $data): float
    {
        return $this->useCase->execute(new InputPromotionUseCase($product, $quantity, $data));
    }
}
