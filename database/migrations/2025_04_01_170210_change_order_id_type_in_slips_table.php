<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderIdTypeInSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slips', function (Blueprint $table) {
            $table->string('order_id')->change();  // Change the order_id column type to string
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slips', function (Blueprint $table) {
            $table->integer('order_id')->change();  // Revert the order_id column type back to integer
        });
    }
}
