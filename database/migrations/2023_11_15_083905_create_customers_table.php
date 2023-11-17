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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('full_name');
            $table->string('address');
            $table->date('year_of_business');
            $table->string('business_type');
            $table->string('business_name');
            $table->string('phone');
            $table->string('state');
            $table->string('lga');
            $table->string('customer_type');
            $table->string('reference_no');
            $table->boolean('account')->default(true);
            $table->boolean('active')->default(false);
            $table->boolean('suspend')->default(false);
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_address')->nullable();
            $table->string('guarantor_phone')->nullable();
            $table->string('relationship_with_applicant')->nullable();
            $table->string('years_of_relationship')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('last_edited_by')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->text('last_login_ip')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
