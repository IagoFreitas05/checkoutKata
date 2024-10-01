<?php


use App\adapter\http\Controllers\CheckoutController;
use App\adapter\services\CheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


it('calculates total price correctly based on the items in the cart', function () {
    $mockCheckoutService = Mockery::mock(CheckoutService::class);
    $totalPrice = 100.00;

    $mockCheckoutService
        ->shouldReceive('calculateTotal')
        ->once()
        ->with([
            'A' => 3,
            'B' => 3,
            'C' => 5,
            'D' => 2,
            'E' => 2,
        ])
        ->andReturn($totalPrice);

    $controller = new CheckoutController($mockCheckoutService);

    $requestPayload = [
        'items' => [
            ['sku' => 'A', 'quantity' => 3],
            ['sku' => 'B', 'quantity' => 3],
            ['sku' => 'C', 'quantity' => 5],
            ['sku' => 'D', 'quantity' => 2],
            ['sku' => 'E', 'quantity' => 2],
        ],
    ];
    $request = Request::create('/checkout/calculate-total', 'POST', $requestPayload);

    $response = $controller->calculateTotal($request);

    expect($response->status())->toBe(200);
});
