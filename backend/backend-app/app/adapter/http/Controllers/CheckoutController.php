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

        // Get the items from the request (array of objects with sku and quantity)
        $items = $request->input('items');  // Example: [{'sku': 'A', 'quantity': 3}, {'sku': 'B', 'quantity': 2}, ...]

        // Convert the items to a format that the service can process
        $itemCounts = [];
        foreach ($items as $item) {
            $itemCounts[$item['sku']] = $item['quantity'];
        }

        // Calculate total using CheckoutService
        $total = $this->checkoutService->calculateTotal($itemCounts);

        return response()->json(['total' => $total]);
    }
}
