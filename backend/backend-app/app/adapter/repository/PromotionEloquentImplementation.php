<?php
// app/Infrastructure/Persistence/PromotionEloquentImplementation.php
namespace App\adapter\repository;

use App\business\entities\Product;
use App\adapter\models\PromotionModel;
use App\business\repositories\Promotions;

class PromotionEloquentImplementation implements Promotions
{
    public function getPromotions($input)
    {
        return PromotionModel::with('promotionType')
            ->where('product_id', $input->getId())
            ->orWhere('related_product_id', $input->getId())
            ->get();
    }
}
