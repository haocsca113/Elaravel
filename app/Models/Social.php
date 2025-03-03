<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Login;

class Social extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'provider_user_id', 'provider', 'user'
    ];
    protected $primaryKey = 'user_id';
    protected $table = 'tbl_social';

    public function login()
    {
        return $this->belongsTo(\App\Models\Login::class, 'user'); // Cột user trong bảng tbl_social chứa khóa ngoại bảng tbl_admin
    }
}
