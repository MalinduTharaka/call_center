<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromRoleInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['role']); // or use the index name if Laravel generated a custom one
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique('role');
        });
    }
}
