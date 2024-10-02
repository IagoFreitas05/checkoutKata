<?php

namespace App\business\repositories;

interface Products
{
    /**
     * Return the current product using SKU
     *
     * @param String $sku
     */
    public function getBySku($input);
}
