<?php
// app/Infrastructure/Persistence/PromotionRepository.php
namespace App\adapter\repository;

use App\business\entities\Product;
use App\adapter\models\PromotionModel;

class PromotionRepository
{
    public function findByProduct(Product $product)
    {
        return PromotionModel::with('promotionType')
            ->where('product_id', $product->getId())
            ->orWhere('related_product_id', $product->getId())
            ->get();
    }
}
