<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'video_title', 'video_slug', 'video_link', 'video_desc', 'video_image'
    ];
    protected $primaryKey = 'video_id';
    protected $table = 'tbl_video';
}
