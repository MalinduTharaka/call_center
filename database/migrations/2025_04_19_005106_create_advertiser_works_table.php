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
        Schema::create('advertiser_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('add_count')->nullable();
            $table->time('complete_time')->nullable();
            $table->time('off_time')->nullable();
            $table->string('ot')->nullable();
            $table->date('date')->nullable();
            $table->string('target')->nullable();
            $table->integer('wte_add_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertiser_works');
    }
};
