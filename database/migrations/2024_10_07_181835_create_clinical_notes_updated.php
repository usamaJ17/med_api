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
        Schema::dropIfExists('clinical_notes_custom_fields');
        Schema::dropIfExists('notes_comments');
        Schema::dropIfExists('clinical_notes');
        Schema::create('clinical_notes', function (Blueprint $table) {
            $table->id();
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('patient_name')->nullable();
            $table->timestamps();
        });
        Schema::create('notes_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinical_note_id')->nullable();
            $table->foreign('clinical_note_id')->references('id')->on('clinical_notes')->onDelete('cascade');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('body')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_comments');
        Schema::dropIfExists('clinical_notes');
    }
};
