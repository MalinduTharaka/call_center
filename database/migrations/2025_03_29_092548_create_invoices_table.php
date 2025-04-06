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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('inv')->nullable();
            $table->string('contact')->nullable();
            $table->unsignedBigInteger('order_id1')->nullable();
            $table->unsignedBigInteger('order_id2')->nullable();
            $table->unsignedBigInteger('order_id3')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
