<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeesToProfessionalTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professional_types', function (Blueprint $table) {
            $table->string('chat_fee', 20)->nullable()->after('existing_column')->after('icon');
            $table->string('audio_fee', 20)->nullable()->after('chat_fee');
            $table->string('video_fee', 20)->nullable()->after('audio_fee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professional_types', function (Blueprint $table) {
            $table->dropColumn(['chat_fee', 'audio_fee', 'video_fee']);
        });
    }
}
