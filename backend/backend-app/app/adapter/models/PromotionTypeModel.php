<?php

namespace App\adapter\models;

use Illuminate\Database\Eloquent\Model;

class PromotionTypeModel extends Model
{
    protected $table = 'promotions_type';
    protected $fillable = ['name'];

    public function promotions()
    {
        return $this->hasMany(PromotionModel::class, 'promotion_type_id');
    }
}
