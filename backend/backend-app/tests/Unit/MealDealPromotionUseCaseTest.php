<?php

use App\adapter\businessUseCases\MealDealPromotionImpl;
use App\business\entities\Product;

describe('MealDealPromotionUseCase', function () {
    it('calculates the total price for meal deal promotion correctly', function () {

        $mainProduct = Mockery::mock(Product::class);
        $mainProduct->shouldReceive('getPrice')->andReturn(200.00);

        // unit price      200  200 200 200 2000
        // related product 50   50  50
        // meal deal price 300  300 300  200 200

        $input = (object)[
            'product' => $mainProduct,
            'quantity' => 5,
            'related_product_sku' => 'side_dish',
            'data' => [
                'related_product_sku' => 'side_dish',
                'related_product_price' => 50.00,
                'itemCounts' => [
                    'side_dish' => 3
                ],
                'discounted_price' => 300.00
            ]
        ];

        $mealDeal = new MealDealPromotionImpl();
        $result = $mealDeal->execute($input);
        $expectedTotal = (3 * 300.00) + (2 * 200.00) + (0 * 50.00);
        expect($result)->toBe($expectedTotal);
    });

    it('calculates the total price for meal deal promotion for 90 and 3 related products', function () {

        $mainProduct = Mockery::mock(Product::class);
        $mainProduct->shouldReceive('getPrice')->andReturn(90.00);

        $input = (object)[
            'product' => $mainProduct,
            'quantity' => 3,
            'related_product_sku' => 'side_dish',
            'data' => [
                'related_product_sku' => 'side_dish',
                'related_product_price' => 50.00,
                'itemCounts' => [
                    'side_dish' => 3
                ],
                'discounted_price' => 50.00
            ]
        ];

        $mealDeal = new MealDealPromotionImpl();
        $result = $mealDeal->execute($input);
        $expectedTotal = (3 * 50.0);
        expect($result)->toBe($expectedTotal);
    });

    it('calculates the total price for meal deal promotion for 100 and 5 related products', function () {

        $mainProduct = Mockery::mock(Product::class);
        $mainProduct->shouldReceive('getPrice')->andReturn(100.00);

        $input = (object)[
            'product' => $mainProduct,
            'quantity' => 10,
            'related_product_sku' => 'side_dish',
            'data' => [
                'related_product_sku' => 'side_dish',
                'related_product_price' => 50.00,
                'itemCounts' => [
                    'side_dish' => 5
                ],
                'discounted_price' => 90.00
            ]
        ];

        $mealDeal = new MealDealPromotionImpl();
        $result = $mealDeal->execute($input);
        $expectedTotal = (5 * 90.0) + (5 * 100.0);
        expect($result)->toBe($expectedTotal);
    });
});
