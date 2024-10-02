<?php
namespace App\adapter\http\Controllers;

use App\adapter\services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * Add items to the cart and calculate the total price with promotions applied.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateTotal(Request $request)
    {
        $items = $request->input('items');

        $itemCounts = [];
        foreach ($items as $item) {
            $itemCounts[$item['sku']] = $item['quantity'];
        }

        $total = $this->checkoutService->calculateTotal($itemCounts);

        return response()->json(['total' => $total]);
    }
}
