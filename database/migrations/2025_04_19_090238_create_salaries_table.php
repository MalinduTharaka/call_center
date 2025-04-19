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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('month')->nullable();
            $table->decimal('basic', 10, 2)->nullable();
            $table->decimal('allowance', 10, 2)->nullable();
            $table->decimal('bonus', 10, 2)->nullable();
            $table->decimal('ot', 10, 2)->nullable();
            $table->decimal('transport', 10, 2)->nullable();
            $table->decimal('leave', 10, 2)->nullable();
            $table->decimal('late', 10, 2)->nullable();
            $table->decimal('attendace_bonus', 10, 2)->nullable();
            $table->decimal('deduction', 10, 2)->nullable();
            $table->decimal('net_salary', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
