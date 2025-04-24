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
        Schema::table('call_center_works', function (Blueprint $table) {
            $table->dropColumn('target');
            $table->unsignedBigInteger('target_id')->nullable()->after('complete_date');
            $table->foreign('target_id')->references('id')->on('targets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('call_center_works', function (Blueprint $table) {
            $table->dropForeign(['target_id']);
            $table->dropColumn('target_id');
            $table->integer('target')->nullable();
        });
    }
};
