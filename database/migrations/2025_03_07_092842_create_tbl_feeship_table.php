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
        Schema::create('tbl_feeship', function (Blueprint $table) {
            $table->increments('fee_id');
            $table->string('fee_matp');
            $table->string('fee_maqh');
            $table->integer('fee_xaid');
            $table->string('fee_feeship');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_feeship');
    }
};
