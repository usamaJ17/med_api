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
        Schema::table("chat_box_messages", function (Blueprint $table) {
            $table->dropColumn("from_user_read");
            $table->dropColumn("to_user_read")->drop();
            $table->tinyInteger("user_read")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
