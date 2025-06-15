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
        Schema::create('net_incomes', function (Blueprint $table) {
            $table->id();
            $table->date('month')->nullable();
            $table->decimal('service', 12, 2)->default(0);
            $table->decimal('designs',10,2)->default(0);
            $table->decimal('video',10,2)->default(0);
            $table->decimal('other',10,2)->default(0);
            $table->decimal('salary',10,2)->default(0);
            $table->decimal('act_payment',10,2)->default(0);
            $table->decimal('dsg_payment',10,2)->default(0);
            $table->decimal('vde_payment',10,2)->default(0);
            $table->decimal('water_bill',10,2)->default(0);
            $table->decimal('ecb_bill',10,2)->default(0);
            $table->decimal('int_bill',10,2)->default(0);
            $table->decimal('rent',10,2)->default(0);
            $table->decimal('other_business',10,2)->default(0);
            $table->decimal('other_deductions',10,2)->default(0);
            $table->decimal('net_income',10,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('net_incomes');
    }
};
