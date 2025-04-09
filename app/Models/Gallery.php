<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id', 'gallery_name', 'gallery_image'
    ];
    protected $primaryKey = 'gallery_id';
    protected $table = 'tbl_gallery';
}
