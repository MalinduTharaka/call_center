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
        Schema::create('order_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('name')->nullable();
            $table->string('cro')->nullable();
            $table->string('contact')->nullable();
            $table->string('order_type')->nullable();
            $table->string('work_type')->nullable();
            $table->string('page')->nullable();
            $table->string('work_status')->nullable();
            $table->text('update')->nullable();
            $table->unsignedBigInteger('advertiser_id')->nullable();
            $table->text('add_acc_id')->nullable();
            $table->string('add_acc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_updates');
    }
};
