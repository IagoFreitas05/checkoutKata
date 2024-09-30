<?php

namespace App\stategies;

use App\business\entities\product;
use App\business\usecases\MultipricedPromotionUseCase;
use Illuminate\Support\Facades\Log;

class PromotionContext
{
    protected $strategies = [];
    private MultipricedPromotionUseCase $multipricedPromotionUseCase;

    public function __construct(multipricedPromotionUseCase $multipricedPromotionUseCase)
    {
        $this->multipricedPromotionUseCase = $multipricedPromotionUseCase;
        // Register strategies
        $this->strategies['multipriced'] = new MultipricedPromotionStrategy($this->multipricedPromotionUseCase);
        $this->strategies['buy_n_get_1_free'] = new BuyNGetOneFreePromotionStrategy();
        $this->strategies['meal_deal'] = new MealDealPromotionStrategy();
    }

    public function calculateTotal($promotionType, Product $product, int $quantity, array $data): float
    {
        if (isset($this->strategies[$promotionType])) {
            return $this->strategies[$promotionType]->execute($product, $quantity, $data);
        }

        throw new \InvalidArgumentException("Invalid promotion type: {$promotionType}");
    }
}
