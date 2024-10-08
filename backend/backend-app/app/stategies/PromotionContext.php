<?php

namespace App\stategies;

use App\adapter\businessUseCases\BuyNGetOneFreePromotionImpl;
use App\business\entities\product;
use App\business\usecases\MealDealPromotionUseCase;
use App\business\usecases\MultipricedPromotionUseCase;

class PromotionContext
{
    protected $strategies = [];
    private MultipricedPromotionUseCase $multipricedPromotionUseCase;
    private MealDealPromotionUseCase $mealDealPromotionUseCase;
    private BuyNGetOneFreePromotionImpl $buyNGetOneFreePromotionUseCase;

    public function __construct(multipricedPromotionUseCase $multipricedPromotionUseCase, MealDealPromotionUseCase $mealDealPromotionUseCase, BuyNGetOneFreePromotionImpl $buyNGetOneFreePromotionUseCase)
    {
        $this->multipricedPromotionUseCase = $multipricedPromotionUseCase;
        $this->mealDealPromotionUseCase = $mealDealPromotionUseCase;
        $this->buyNGetOneFreePromotionUseCase = $buyNGetOneFreePromotionUseCase;

        $this->strategies['multipriced'] = new MultipricedPromotionStrategy($this->multipricedPromotionUseCase);
        $this->strategies['buy_n_get_1_free'] = new BuyNGetOneFreePromotionStrategy($this->buyNGetOneFreePromotionUseCase);
        $this->strategies['meal_deal'] = new MealDealPromotionStrategy($this->mealDealPromotionUseCase);
    }

    public function calculateTotal($promotionType, Product $product, int $quantity, array $data): float
    {
        if (isset($this->strategies[$promotionType])) {
            return $this->strategies[$promotionType]->execute($product, $quantity, $data);
        }

        throw new \InvalidArgumentException("Invalid promotion type: {$promotionType}");
    }
}
