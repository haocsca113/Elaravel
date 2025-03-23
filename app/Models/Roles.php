<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class Roles extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    protected $primaryKey = 'id_roles';
    protected $table = 'tbl_roles';

    public function admin()
    {
        return $this->belongsToMany(\App\Models\Admin::class); // Roles thuoc nhieu admin
    }
}
