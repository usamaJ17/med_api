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
        Schema::table('consultation_summary_fields', function (Blueprint $table) {            
            $table->enum('type', ['Prescription', 'Non-Prescription'])->default('Non-Prescription')->after('is_required');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_summary_fields', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
