<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cartify_users', function (Blueprint $table) {
            $table->id();
            $table->string('cartify_user_id')->unique();
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('email_id')->unique();
            $table->string('mobile_number', 10)->unique();
            $table->string('password');
            $table->string('profile_picture_path')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
            $table->timestampTz('email_verified_at')->nullable();
            $table->timestampTz('mobile_verified_at')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cartify_users');
    }
};
