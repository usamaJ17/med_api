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
        Schema::table('consultation_fee', function (Blueprint $table) {
            // Change the `fee` column to string
            $table->string('fee')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_fee', function (Blueprint $table) {
            $table->decimal('fee', 8, 2)->change();
        });
    }
};
