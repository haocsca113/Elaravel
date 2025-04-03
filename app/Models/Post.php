<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'cate_post_id', 'post_title', 'post_slug', 'post_desc', 'post_content', 'post_meta_desc', 'post_meta_keywords', 'post_image', 'post_status'
    ];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_post';

    public function cate_post()
    {
        return $this->belongsTo(\App\Models\CategoryPost::class, 'cate_post_id');
    }
}
