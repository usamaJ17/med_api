<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumFeeToProfesssionalTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('professsional_types', function (Blueprint $table) {
            $table->string('minimum_fee')->nullable()->after('icon'); // Add the column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professsional_types', function (Blueprint $table) {
            $table->dropColumn('minimum_fee'); // Remove the column if rolled back
        });
    }
}
