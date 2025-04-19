<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeOptionalColumnsNullableInOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('fb_fee', 10, 2)->nullable()->change();
            $table->decimal('advance', 10, 2)->nullable()->change();
            $table->decimal('amount', 10, 2)->nullable()->change();
            $table->decimal('package_amt', 10, 2)->nullable()->change();
            $table->decimal('tax', 10, 2)->nullable()->change();
            $table->decimal('service', 10, 2)->nullable()->change();
            $table->decimal('advance', 10, 2)->nullable()->change();
            $table->decimal('our_amount', 10, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert to non-nullable if needed (optional)
            $table->decimal('fb_fee', 10, 2)->nullable(false)->change();
            $table->decimal('advance', 10, 2)->nullable(false)->change();
            $table->decimal('amount', 10, 2)->nullable(false)->change();
            $table->decimal('package_amt', 10, 2)->nullable(false)->change();
            $table->decimal('tax', 10, 2)->nullable(false)->change();
            $table->decimal('service', 10, 2)->nullable(false)->change();
        });
    }
}
