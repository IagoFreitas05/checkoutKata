<?php

namespace App\business\repositories;

use App\business\entities\Product;

interface Products
{
    /**
     * Return the current product using SKU
     *
     * @param String $sku
     */
    public function getBySku($input);
}
