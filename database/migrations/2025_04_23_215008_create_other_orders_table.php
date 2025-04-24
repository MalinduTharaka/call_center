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
        Schema::create('other_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('ce')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('cc_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('work_type')->nullable();
            $table->string('note')->nullable();
            $table->string('work_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('cash', 4, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('advance', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_orders');
    }
};
