<?php

namespace App\adapter\repository;

use App\adapter\models\ProductModel;
use App\business\entities\Product;
use App\business\repositories\Products;

class ProductEloquentImplementation implements Products
{

    public function getBySku($input): Product | Null
    {
        $productModel = ProductModel::where('sku', $input)->first();
        return new Product($productModel->sku, $productModel->name, $productModel->price, $productModel->id);
    }
}
