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
        Schema::table('appointments', function (Blueprint $table) {
            $table->boolean('24_hours_email_sent')->default(false);
            $table->boolean('12_hours_email_sent')->default(false);
            $table->boolean('1_hour_email_sent')->default(false);
            $table->boolean('15_minutes_email_sent')->default(false);
            $table->boolean('appointment_is_due')->default(false);
            $table->boolean('12_hours_email_sent_p')->default(false);
            $table->boolean('1_hour_email_sent_p')->default(false);
            $table->boolean('15_minutes_email_sent_p')->default(false);
            $table->boolean('appointment_is_due_p')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                '24_hours_email_sent',
                '12_hours_email_sent',
                '1_hour_email_sent',
                '15_minutes_email_sent',
                'appointment_is_due',
                '12_hours_email_sent_p',
                '1_hour_email_sent_p',
                '15_minutes_email_sent_p',
                'appointment_is_due_p'
            ]);
        });
    }
};
