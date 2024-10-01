<?php

namespace App\adapter\services;


use App\business\repositories\Products;
use App\business\repositories\Promotions;
use App\stategies\PromotionContext;



class CheckoutService
{
    private $promotionRepository;
    private $promotionContext;
    private $productRepository;

    public function __construct(
        Promotions $promotionRepository,
        PromotionContext    $promotionContext,
        Products            $productRepository
    )
    {
        $this->promotionRepository = $promotionRepository;
        $this->promotionContext = $promotionContext;
        $this->productRepository = $productRepository;
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
            $productEntity = $this->productRepository->getBySku($sku);
            if ($productEntity != null) {
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
