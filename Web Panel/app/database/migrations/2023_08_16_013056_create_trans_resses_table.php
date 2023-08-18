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
        Schema::create('trans_resses', function (Blueprint $table) {
            $table->id();
            $table->string('desc_trans');
            $table->string('amount_trans');
            $table->string('date_time');
            $table->string('username_trans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_resses');
    }
};
