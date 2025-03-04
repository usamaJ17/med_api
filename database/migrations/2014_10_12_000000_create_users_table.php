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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('contact')->nullable();
            $table->string('forgot_password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->string('password');
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('language')->nullable();
            $table->string('otp')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_live')->default(false);
            $table->string('temp_role')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
