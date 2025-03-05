<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_vnpay', function (Blueprint $table) {
            $table->increments('vnpay_id');
            $table->string('vnp_amount');
            $table->string('vnp_bankcode');
            $table->string('vnp_banktranno');
            $table->string('vnp_cardtype');
            $table->string('vnp_orderinfo');
            $table->string('vnp_paydate');
            $table->string('vnp_tmncode');
            $table->string('vnp_transactionno');
            $table->string('code_cart');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_vnpay');
    }
};
