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
        Schema::table('emergency_help', function (Blueprint $table) {
            $table->float('amount')->default(0.0);
            $table->string('duration')->nullable();
            $table->string('method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emergency_help', function (Blueprint $table) {
            //
        });
    }
};
