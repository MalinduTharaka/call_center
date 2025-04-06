<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePackageColumnsInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Rename package_id to package_amt and change its type to decimal
            $table->renameColumn('package_id', 'package_amt');
            $table->decimal('package_amt', 10, 2)->nullable()->change(); // Ensure it's decimal type

            // Add new columns 'service' and 'tax'
            $table->decimal('service', 10, 2)->after('package_amt')->nullable();
            $table->decimal('tax', 10, 2)->after('service')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the new columns and rename back package_amt to package_id
            $table->dropColumn(['service', 'tax']);
            $table->renameColumn('package_amt', 'package_id');
        });
    }
}
