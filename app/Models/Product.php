<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImageProduct;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'thumbnail',
        'description',
        'detail',
        'cat_id',
        'brand_id',
        'price',
        'quantity',
        'status'
    ];

    public function images() {
        return $this->hasMany(ImageProduct::class, 'product_id', 'id');
    }
}
