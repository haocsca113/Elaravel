<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'category_id', 'brand_id', 'product_name', 'product_tags', 'product_quantity', 'product_desc', 'product_content', 'product_price', 'product_image', 'product_status', 'meta_keywords', 'product_views', 'price_cost'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function comment()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function category()
    {
        return $this->beLongsTo(\App\Models\Category::class, 'category_id');
    }
}
