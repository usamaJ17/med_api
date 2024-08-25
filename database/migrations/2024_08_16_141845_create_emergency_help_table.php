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
        Schema::create('emergency_help', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('med_id')->nullable();
            $table->foreign('med_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('emergency_type')->nullable();
            $table->string('status')->default('requested')->nullable();
            $table->dateTime('requested_at')->nullable();
            $table->boolean('is_mid_night')->default(0)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_help');
    }
};
