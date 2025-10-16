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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id_product');
            $table->unsignedInteger('id_user')->nullable()->index();
            $table->unsignedInteger('id_category')->nullable()->index();
            $table->unsignedInteger('id_Qualification')->nullable()->index();
            $table->integer('price')->nullable();
            $table->string('product_name', 50);
            $table->string('product_description', 100)->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('weight_kg', 10, 2)->nullable()->default(1.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
