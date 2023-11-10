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
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('promo_product')->default(false);
            $table->string('promo_code')->default('PROMO00-00');
            $table->string('reference_number');
            $table->integer('cases');
            $table->string('slug');
            $table->mediumText('short_description')->nullable();
            $table->mediumText('description');
            $table->bigInteger('quantity');
            $table->bigInteger('price');
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
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
