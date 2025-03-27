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
        Schema::table('chat_box', function (Blueprint $table) {
            $table->integer('unread_count_sender')->default(0)->nullable();
            $table->integer('unread_count_receiver')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_box', function (Blueprint $table) {
            //
        });
    }
};
