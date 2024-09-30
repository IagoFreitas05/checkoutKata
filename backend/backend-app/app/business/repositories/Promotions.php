<?php

namespace App\business\repositories;
use App\business\entities\Product;

interface Promotions
{
    /**
     * Calculate the total price for the items in the cart.
     *
     * @param Product $input
     */
    public function getPromotions($input);
}
