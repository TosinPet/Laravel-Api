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
        Schema::table('customer_deposit', function (Blueprint $table) {
            //
            // $table->dropForeign('customer_deposit_user_id_foreign');
            // $table->dropColumn('user_id');
            $table->dropForeign(['customer_account_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_deposit', function (Blueprint $table) {
            //
        });
    }
};
