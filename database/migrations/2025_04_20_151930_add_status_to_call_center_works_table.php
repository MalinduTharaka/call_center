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
            $table->integer('status')->default(1)->after('complete_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('call_center_works', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
