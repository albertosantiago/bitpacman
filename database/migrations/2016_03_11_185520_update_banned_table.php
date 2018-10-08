<?php

use Illuminate\Database\Migrations\Migration;

class UpdateBannedTable extends Migration
{
    public function up()
    {
        Schema::table('banned', function ($table) {
            $table->string('network');
        });
    }

    public function down()
    {
    }
}
