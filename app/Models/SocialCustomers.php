<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialCustomers extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'provider_user_id', 'provider_user_email', 'provider', 'user'
    ];
    protected $primaryKey = 'user_id';
    protected $table = 'tbl_social_customers';

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'user'); 
    }
}
