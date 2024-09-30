<?php

namespace App\stategies;

use App\business\entities\Product;
use App\business\usecases\io\InputPromotionUseCase;
use App\business\usecases\MultipricedPromotionUseCase;
use Illuminate\Support\Facades\Log;

class MultipricedPromotionStrategy implements PromotionStrategyInterface
{
    private MultipricedPromotionUseCase $useCase;

    public function __construct(MultipricedPromotionUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function execute(Product $product, int $quantity, $data): float
    {

        $data = new InputPromotionUseCase($product, $quantity, $data);
        return $this->useCase->execute($data);
    }
}
