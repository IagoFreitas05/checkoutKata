<?php

use App\adapter\businessUseCases\BuyNGetOneFreePromotionUseCase;
use App\business\entities\Product;

describe("BuyNGetOneFresUseCase", function () {
    it('calculates to 5 products should be 400', function () {
        $product = Mockery::mock(Product::class);
        $product->shouldReceive('getPrice')->andReturn(100.00);

        $input = (object)[
            'quantity' => 5,
            'data' => [
                'required_quantity' => 2
            ],
            'product' => $product
        ];

        $useCase = new BuyNGetOneFreePromotionUseCase();
        $result = $useCase->execute($input);
        expect($result)->toBe(400.00);
    });

    it('calculates to 3 products should be 400', function () {
        $product = Mockery::mock(Product::class);
        $product->shouldReceive('getPrice')->andReturn(100.00);

        $input = (object)[
            'quantity' => 3,
            'data' => [
                'required_quantity' => 2
            ],
            'product' => $product
        ];

        $useCase = new BuyNGetOneFreePromotionUseCase();
        $result = $useCase->execute($input);
        expect($result)->toBe(200.00);
    });

    it('calculates to 3 products should be 300', function () {
        $product = Mockery::mock(Product::class);
        $product->shouldReceive('getPrice')->andReturn(100.00);

        $input = (object)[
            'quantity' => 3,
            'data' => [
                'required_quantity' => 3
            ],
            'product' => $product
        ];

        $useCase = new BuyNGetOneFreePromotionUseCase();
        $result = $useCase->execute($input);
        expect($result)->toBe(300.00);
    });

    it('calculates to 4 products should be 300', function () {
        $product = Mockery::mock(Product::class);
        $product->shouldReceive('getPrice')->andReturn(100.00);

        $input = (object)[
            'quantity' => 4,
            'data' => [
                'required_quantity' => 3
            ],
            'product' => $product
        ];

        $useCase = new BuyNGetOneFreePromotionUseCase();
        $result = $useCase->execute($input);
        expect($result)->toBe(300.00);
    });
});

