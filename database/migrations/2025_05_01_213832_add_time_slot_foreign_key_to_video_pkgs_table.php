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
        Schema::table('video_pkgs', function (Blueprint $table) {
            // Change column type to match time_slots.id type
            $table->unsignedBigInteger('time')->nullable()->change();
            
            // Add foreign key constraint
            $table->foreign('time')
                  ->references('id')
                  ->on('time_slots')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_pkgs', function (Blueprint $table) {
            $table->dropForeign(['time']);
            $table->string('time')->nullable()->change();
        });
    }
};
