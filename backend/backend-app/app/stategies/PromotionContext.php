<?php

namespace App\stategies;

use App\business\entities\product;
class PromotionContext
{
    protected $strategies = [];

    public function __construct()
    {
        // Register strategies
        $this->strategies['multipriced'] = new MultipricedPromotionStrategy();
        $this->strategies['buy_n_get_1_free'] = new BuyNGetOneFreePromotionStrategy();
        $this->strategies['meal_deal'] = new MealDealPromotionStrategy();
    }

    public function calculateTotal($promotionType, Product $product, int $quantity, array $data): float
    {
        if (isset($this->strategies[$promotionType])) {
            // Pass the relevant data to the promotion strategy
            return $this->strategies[$promotionType]->execute($product, $quantity, $data);
        }

        throw new \InvalidArgumentException("Invalid promotion type: {$promotionType}");
    }
}
