<?php
// app/Infrastructure/Persistence/ProductModel.php
namespace App\adapter\models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['sku', 'name', 'price'];

    public function promotions()
    {
        return $this->hasMany(PromotionModel::class, 'product_id');
    }
}
