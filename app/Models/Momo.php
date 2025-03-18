<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Momo extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'partner_code', 'order_id', 'amount', 'order_info', 'order_type', 'trans_id', 'pay_type'
    ];
    protected $primaryKey = 'momo_id';
    protected $table = 'tbl_momo';
}
