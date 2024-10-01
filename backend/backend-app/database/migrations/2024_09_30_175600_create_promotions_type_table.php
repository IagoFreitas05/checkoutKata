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
        Schema::create('promotions_type', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // e.g., 'multipriced', 'buy_n_get_1_free', 'meal_deal'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions_type');
    }
};
