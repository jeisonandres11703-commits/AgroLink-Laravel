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
        Schema::create('tb_product_images', function (Blueprint $table) {
            $table->increments('id_image');
            $table->unsignedInteger('id_product')->nullable()->index();
            $table->string('file_path', 250)->nullable();
            $table->enum('file_type', ['image', 'video'])->nullable()->default('image');
            $table->boolean('is_primary')->nullable()->default(0);
            $table->timestamp('uploaded_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_product_images');
    }
};
