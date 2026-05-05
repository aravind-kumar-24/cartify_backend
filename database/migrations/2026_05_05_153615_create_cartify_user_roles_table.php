<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cartify_user_roles', function (Blueprint $table) {
            $table->id();
            $table->enum('role_name', ['buyer', 'seller', 'admin']);
            $table->foreignId('cartify_user_id')->constrained('cartify_users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cartify_user_roles');
    }
};
