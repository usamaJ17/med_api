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
        Schema::create('transaction_history', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_type')->nullable();
            $table->float('transaction_amount')->default(0.0)->nullable();
            $table->string('transaction_currency')->nullable();
            $table->string('transaction_description')->nullable();
            $table->date('transaction_date')->nullable();
            $table->time('transaction_time')->nullable();
            $table->integer('appointment_id')->nullable();
            $table->string('transaction_gateway')->nullable();  
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_history');
    }
};
