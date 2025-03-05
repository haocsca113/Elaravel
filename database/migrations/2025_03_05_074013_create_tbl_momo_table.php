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
        Schema::create('tbl_momo', function (Blueprint $table) {
            $table->increments('momo_id');
            $table->string('partner_code');
            $table->integer('order_id');
            $table->string('amount');
            $table->string('order_info');
            $table->string('order_type');
            $table->integer('trans_id');
            $table->string('pay_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_momo');
    }
};
