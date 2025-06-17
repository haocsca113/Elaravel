<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'coupon_name', 'coupon_code', 'coupon_time', 'coupon_condition', 'coupon_number', 'coupon_date_start', 'coupon_date_end', 'coupon_status', 'coupon_used'
    ];
    protected $primaryKey = 'coupon_id';
    protected $table = 'tbl_coupon';
}
