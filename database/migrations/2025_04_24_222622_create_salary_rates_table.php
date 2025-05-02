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
        Schema::create('salary_rates', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable();
            $table->decimal('basic', 10, 2)->nullable();
            $table->decimal('allowance', 10, 2)->nullable();
            $table->decimal('b_bonus', 10, 2)->nullable();
            $table->decimal('v_bonus', 10, 2)->nullable();
            $table->decimal('ad_bonus', 10, 2)->nullable();
            $table->decimal('at_bonus', 10, 2)->nullable();
            $table->decimal('ot', 10, 2)->nullable();
            $table->decimal('transport', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_rates');
    }
};
