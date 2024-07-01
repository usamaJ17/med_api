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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('med_id');
            $table->foreign('med_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('appointment_type');
            $table->string('consultation_fees');
            $table->time('appointment_time');
            $table->date('appointment_date');
            $table->string('gender');
            $table->string('age');
            $table->text('problem');
            $table->boolean('is_paid')->default(1);
            $table->string('status')->default('upcoming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};
