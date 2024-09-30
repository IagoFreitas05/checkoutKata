<?php

namespace App\adapter\services;


use App\business\repositories\Promotions;
use App\stategies\PromotionContext;
use App\adapter\models\ProductModel;
use App\business\entities\Product;



class CheckoutService
{
    private $promotionRepository;
    private $promotionContext;

    public function __construct(
        Promotions $promotionRepository,
        PromotionContext    $promotionContext,
    )
    {
        $this->promotionRepository = $promotionRepository;
        $this->promotionContext = $promotionContext;
    }

    /**
     * Calculate the total price for the items in the cart.
     *
     * @param array $items Array of SKU and quantity pairs (e.g., ['A' => 3, 'B' => 2])
     * @return float The total price after applying promotions
     */
    public function calculateTotal(array $items): float
    {
        $total = 0;
        foreach ($items as $sku => $quantity) {
            $productModel = ProductModel::where('sku', $sku)->first();

            if ($productModel) {
                $productEntity = new Product($productModel->sku, $productModel->name, $productModel->price, $productModel->id);
                $promotions = $this->promotionRepository->getPromotions($productEntity);
                if ($promotions->isEmpty()) {
                    // If there are no promotions, add the product's regular price to the total
                    $total += $productEntity->getPrice() * $quantity;
                } else {
                    foreach ($promotions as $promotion) {
                        // Gather promotion data in a unified format
                        $data = [
                            'itemCounts' => $items,
                            'related_product_sku' => $promotion->relatedProduct->sku ?? null,
                            'related_product_price' => $promotion->relatedProduct->price ?? 0,
                            'quantity' => $promotion->quantity,
                            'discounted_price' => $promotion->discounted_price,
                            'required_quantity' => $promotion->required_quantity,
                        ];

                        // Call the promotion context with the promotion type and data
                        $total += $this->promotionContext->calculateTotal(
                            $promotion->promotionType->name,
                            $productEntity,
                            $quantity,
                            $data
                        );
                    }
                }

            } else {
                throw new \Exception("Product with SKU {$sku} not found.");
            }
        }
        return number_format($total / 100, 2);
    }
}
