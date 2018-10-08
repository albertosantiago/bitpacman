<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBannedSetNullable extends Migration
{
    public function up()
    {
        Schema::table('banned', function ($table) {
            $table->string('ip', 45)->nullable()->change();
            $table->string('address', 125)->nullable()->change();
        });
    }

    public function down(){}
}
