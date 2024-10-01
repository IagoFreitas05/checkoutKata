<?php

use App\adapter\businessUseCases\MultipricedPromotionImpl;

describe('MultipricedPromotionUseCase', function () {
    it('calculates the total price correctly for promotional products', function () {

        $input = (object)[
            'quantity' => 10,
            'data' => [
                'discounted_price' => 200.00,
                'quantity' => 5,
                'regular_price' => 50.00
            ]
        ];

        $useCase = new MultipricedPromotionImpl();

        $result = $useCase->execute($input);

        $expectedTotal = (5 * 40.00) + (5 * 50.00);

        expect($result)->toBe($expectedTotal);
    });

    it('calculates the total price correctly for promotional 10 and 5 with discount', function () {

        $input = (object)[
            'quantity' => 10,
            'data' => [
                'discounted_price' => 200.00,
                'quantity' => 5,
                'regular_price' => 50.00
            ]
        ];

        $useCase = new MultipricedPromotionImpl();

        $result = $useCase->execute($input);

        $expectedTotal = 200.00 + (5 * 50.00);

        expect($result)->toBe($expectedTotal);
    });

    it('charges regular price when quantity is below the required for discount', function () {
        $input = (object)[
            'quantity' => 3,
            'data' => [
                'discounted_price' => 200.00,
                'quantity' => 5,
                'regular_price' => 50.00
            ]
        ];

        $useCase = new MultipricedPromotionImpl();
        $result = $useCase->execute($input);
        $expectedTotal = $input->quantity * ($input->data['discounted_price'] / $input->data['quantity']);

        expect($result)->toBe($expectedTotal);
    });
});
