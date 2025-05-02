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
        Schema::create('design_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_type_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('work_type_id')
                  ->references('id')
                  ->on('work_types')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_payments');
    }
};
