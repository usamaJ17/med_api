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
        Schema::create('medical_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming the details are related to a user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('past_surgical_history')->nullable();
            $table->text('past_medical_history')->nullable();
            $table->text('allergy')->nullable();
            $table->text('drugs_history')->nullable();
            $table->text('gynaecological_history')->nullable();
            $table->text('obstetric_history')->nullable();
            $table->text('recent_hospital_stays')->nullable();
            $table->text('family_history')->nullable();
            $table->text('social_history')->nullable();
            $table->string('occupation')->nullable();
            $table->float('height');
            $table->float('weight');
            $table->string('previous_occupation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_details');
    }
};
