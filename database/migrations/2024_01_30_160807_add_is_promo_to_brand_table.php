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
        Schema::table('brands', function (Blueprint $table) {
            //
            $table->decimal('discount_percentage')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
        });
        \Illuminate\Support\Facades\DB::table('brands')->where('promotion_id', 0)->update(['promotion_id' => 1]);

        Schema::table('brands', function (Blueprint $table) {
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            //
            $table->dropForeign(['promotion_id']);
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['promotion_id']);
        });
    }
};
