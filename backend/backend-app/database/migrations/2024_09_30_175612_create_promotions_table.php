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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');  // Primary product
            $table->foreignId('related_product_id')->nullable()->constrained('products');  // Secondary product for meal deal
            $table->foreignId('promotion_type_id')->constrained('promotions_type');  // Foreign key to promotion types
            $table->integer('quantity')->nullable();  // For multipriced or buy n get 1 free
            $table->integer('discounted_price')->nullable();  // For multipriced promotions or meal deal
            $table->integer('required_quantity')->nullable();  // For buy n get 1 free
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
