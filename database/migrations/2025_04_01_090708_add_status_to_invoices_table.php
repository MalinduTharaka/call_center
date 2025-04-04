<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('amt1')->nullable();
            $table->string('amt2')->nullable();
            $table->string('amt3')->nullable();
            $table->string('status')->default('pending')->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('amt1');
            $table->dropColumn('amt2');
            $table->dropColumn('amt3');
            $table->dropColumn('status');
        });
    }
};
