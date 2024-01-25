<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('brand_id')->nullable();
        });

        // Update existing banners gradually
        \Illuminate\Support\Facades\DB::table('banners')->where('brand_id', 0)->update(['brand_id' => 1]);

        // Set foreign key constraint after updating data
        Schema::table('banners', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            //
            $table->dropForeign(['brand_id']);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('brand_id');
        });
    }
};
