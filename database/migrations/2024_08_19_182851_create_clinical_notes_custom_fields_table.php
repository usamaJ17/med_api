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
        Schema::create('clinical_notes_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinical_note_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('field_name');
            $table->string('field_value')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('clinical_note_id')->references('id')->on('clinical_notes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_notes_custom_fields');
    }
};
