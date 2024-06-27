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
        Schema::create('professional_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('profession')->nullable();
            $table->integer('rank')->nullable();
            $table->string('license_authority')->nullable();
            $table->string('regestraion_number')->nullable();
            $table->string('work_at')->nullable();
            $table->string('experence')->nullable();
            $table->text('bio')->nullable();
            $table->string('degree')->nullable();
            $table->string('institution')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_details');
    }
};
