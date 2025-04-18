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
            $table->string('appointment_type')->nullable();
            $table->string('consultation_fees')->nullable();
            $table->time('appointment_time')->nullable();
            $table->date('appointment_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('problem')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->string('status')->default('upcoming');
            $table->string('patient_status')->default('new_patient');
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
