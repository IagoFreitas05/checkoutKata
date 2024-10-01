<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\adapter\models\ProductModel;
use App\adapter\models\PromotionModel;
use App\adapter\models\PromotionTypeModel;

class ProductsAndPromotionsSeeder extends Seeder
{
    public function run()
    {
        // Create Promotion Types
        $multipriced = PromotionTypeModel::create(['name' => 'multipriced']);
        $buyNGetOneFree = PromotionTypeModel::create(['name' => 'buy_n_get_1_free']);
        $mealDeal = PromotionTypeModel::create(['name' => 'meal_deal']);

        // Create Products
        $productA = ProductModel::create(['sku' => 'A', 'name' => 'Item A', 'price' => 50]);
        $productB = ProductModel::create(['sku' => 'B', 'name' => 'Item B', 'price' => 75]);
        $productC = ProductModel::create(['sku' => 'C', 'name' => 'Item C', 'price' => 25]);
        $productD = ProductModel::create(['sku' => 'D', 'name' => 'Item D', 'price' => 150]);
        $productE = ProductModel::create(['sku' => 'E', 'name' => 'Item E', 'price' => 200]);

        // Create Promotions
        // For Item A: Buy 3 for £1.30
        PromotionModel::create([
            'product_id' => $productA->id,
            'promotion_type_id' => $multipriced->id,
            'quantity' => 3,
            'discounted_price' => 130,
        ]);

        // For Item B: Buy 2 for £1.25
        PromotionModel::create([
            'product_id' => $productB->id,
            'promotion_type_id' => $multipriced->id,
            'quantity' => 2,
            'discounted_price' => 125,
        ]);

        // For Item C: Buy 3, get 1 free
        PromotionModel::create([
            'product_id' => $productC->id,
            'promotion_type_id' => $buyNGetOneFree->id,
            'required_quantity' => 3,
        ]);

        // Meal Deal: Buy D and E together for £3
        PromotionModel::create([
            'product_id' => $productD->id,
            'related_product_id' => $productE->id, // Associate E with D for meal deal
            'promotion_type_id' => $mealDeal->id,
            'discounted_price' => 300,
        ]);
    }
}
