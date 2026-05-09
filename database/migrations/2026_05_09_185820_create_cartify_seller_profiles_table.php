<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cartify_seller_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cartify_user_id')->constrained('cartify_users');
            $table->string('business_name');
            $table->foreignId('business_type_id')->constrained('business_types');
            $table->string('business_address', 255);
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('state_id')->constrained('states');
            $table->string('pincode', 6);
            $table->enum('kyc_status',['pending','submitted', 'rejected', 'approved'])->default('pending');
            $table->text('kyc_rejected_reason')->nullable();
            $table->string('aadhar_number', 12)->unique()->nullable();
            $table->string('aadhar_document_path')->nullable();
            $table->string('gst_number', 15)->unique()->nullable();
            $table->string('gst_document_path')->nullable();
            $table->string('pan_number', 10)->unique()->nullable();
            $table->string('pan_document_path')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->unique()->nullable();
            $table->string('ifsc_code', 11)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_proof_document_path')->nullable();
            $table->string('business_logo_path')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('cartify_seller_profiles');
    }
};
