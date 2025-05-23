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
        Schema::table('order_updates', function (Blueprint $table) {

            // Add new columns
            $table->unsignedBigInteger('advertiser_id_new')->nullable()->after('advertiser_id');
            $table->text('add_acc_id_new')->nullable()->after('add_acc_id')->nullable();
            $table->unsignedBigInteger('upsheet_uid')->nullable()->after('add_acc_id_new');

            // Change default of work_status
            $table->string('work_status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_updates', function (Blueprint $table) {
            // Revert changes
            $table->string('add_acc_id')->change();

            $table->dropColumn('advertiser_id_new');
            $table->dropColumn('add_acc_id_new');
            $table->dropColumn('upsheet_uid');

            $table->string('work_status')->nullable()->default(null)->change();
        });
    }
};
