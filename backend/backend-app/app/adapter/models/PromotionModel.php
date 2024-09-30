<?php
// app/Infrastructure/Persistence/PromotionModel.php
namespace App\adapter\models;
use Illuminate\Database\Eloquent\Model;

class PromotionModel extends Model
{
    protected $table = 'promotions';
    protected $fillable = [
        'product_id',
        'related_product_id',  // For meal deals (D + E for a fixed price)
        'promotion_type_id',
        'quantity',
        'discounted_price',
        'required_quantity',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function relatedProduct()
    {
        return $this->belongsTo(ProductModel::class, 'related_product_id');
    }

    public function promotionType()
    {
        return $this->belongsTo(PromotionTypeModel::class, 'promotion_type_id');
    }
}
