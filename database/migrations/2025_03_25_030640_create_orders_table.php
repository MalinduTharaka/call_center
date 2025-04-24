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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_type')->nullable();
            $table->date('date')->nullable();
            $table->string('ce')->nullable();
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('cro')->nullable();
            $table->foreignId('work_type_id')->nullable();
            $table->string('page')->nullable();
            $table->string('work_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('cash', 10, 2)->nullable();
            $table->unsignedBigInteger('advertiser_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('advance', 10, 2)->nullable();
            $table->string('details')->nullable();
            $table->string('add_acc')->nullable();
            $table->decimal('our_amount', 10, 2)->nullable();
            $table->string('script')->nullable();
            $table->string('shoot')->nullable();
            $table->string('designer_id')->nullable();
            $table->string('invoice')->nullable();
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
