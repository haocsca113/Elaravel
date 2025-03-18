<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VNPay extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'vnp_amount', 'vnp_bankcode', 'vnp_banktranno', 'vnp_cardtype', 'vnp_orderinfo', 'vnp_paydate', 'vnp_tmncode', 'vnp_transactionno', 'code_cart'
    ];
    protected $primaryKey = 'vnpay_id';
    protected $table = 'tbl_vnpay';
}
