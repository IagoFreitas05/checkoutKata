<?php

namespace App\adapter\services;


use App\Adapter\Repository\PromotionRepository;
use App\stategies\PromotionContext;
use App\adapter\models\ProductModel;
use App\business\entities\Product;
use Illuminate\Support\Facades\Log;

class CheckoutService
{
    private $promotionRepository;
    private $promotionContext;

    public function __construct(
        PromotionRepository $promotionRepository,
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
                $promotions = $this->promotionRepository->findByProduct($productEntity);

                if ($promotions->isEmpty()) {
                    // If there are no promotions, add the product's regular price to the total
                    $total += $productEntity->getPrice() * $quantity;
                } else {
                    foreach ($promotions as $promotion) {
                        // Now you can safely access promotionType as an object
                        $promotionType = $promotion->promotionType->name;

                        if ($promotionType === 'meal_deal') {
                            // Handle the meal deal logic
                            $isMainProduct = $promotion->product_id === $productEntity->getId();

                            // Handle the related product potentially being null
                            $relatedProduct = $promotion->relatedProduct;

                            $relatedProductSku = $relatedProduct ? $relatedProduct->sku : null;
                            $relatedProductPrice = $relatedProduct ? $relatedProduct->price : 0; // Default to 0 if null

                            // If the related product is null, we can't apply the meal deal
                            if ($relatedProductSku && isset($items[$relatedProductSku])) {
                                $total += $this->promotionContext->calculateTotal(
                                    'meal_deal',
                                    $productEntity,
                                    $quantity,
                                    [
                                        'itemCounts' => $items,
                                        'related_product_sku' => $relatedProductSku,
                                        'related_product_price' => $relatedProductPrice,
                                        'discounted_price' => $promotion->discounted_price
                                    ]
                                );
                            } else {
                                // If the related product is missing, fall back to the regular product price
                                $total += $productEntity->getPrice() * $quantity;
                            }
                        } else {
                            // Handle other promotions (multipriced, buy_n_get_1_free)
                            $total += $this->promotionContext->calculateTotal(
                                $promotionType,
                                $productEntity,
                                $quantity,
                                [
                                    'quantity' => $promotion->quantity,
                                    'discounted_price' => $promotion->discounted_price,
                                    'required_quantity' => $promotion->required_quantity,
                                ]
                            );
                        }
                    }
                }
            } else {
                throw new \Exception("Product with SKU {$sku} not found.");
            }
        }

        return $total;
    }
}
