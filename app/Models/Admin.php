<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    
    protected $fillable = [
        'admin_email', 'admin_password', 'admin_name', 'admin_phone'
    ];
    protected $primaryKey = 'admin_id';
    protected $table = 'tbl_admin';

    protected $hidden = [
        'admin_password',
    ];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Roles::class); // admin co nhieu quyen
    }
}
