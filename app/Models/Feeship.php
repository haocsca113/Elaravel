<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fee_matp', 'fee_maqh', 'fee_xaid', 'fee_feeship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship';

    public function city()
    {
        //return $this->belongsTo('City::class', 'fee_matp'); // feeship thuoc ve model City, Model City lay id so sanh voi fee_matp

        return $this->belongsTo(\App\Models\City::class, 'fee_matp');
    }
    public function province()
    {
        // return $this->belongsTo('Province::class', 'fee_maqh'); 
        return $this->belongsTo(\App\Models\Province::class, 'fee_maqh');
    }
    public function ward()
    {
        // return $this->belongsTo('Ward::class', 'fee_xaid');
        return $this->belongsTo(\App\Models\Ward::class, 'fee_xaid');
    }
}
