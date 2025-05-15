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
        Schema::create('refund_other_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('name')->nullable();
            $table->string('cro')->nullable();
            $table->string('contact')->nullable();
            $table->string('work_type')->nullable();
            $table->text('reason');
            $table->decimal('amount' , 10, 2)->nullable();
            $table->decimal('advance' , 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_other_orders');
    }
};
