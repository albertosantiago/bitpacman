<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBannedAddReason extends Migration
{
    public function up()
    {
        Schema::table('banned', function ($table) {
            $table->string('reason', 150)->nullable();
        });
    }

    public function down()
    {
        Schema::table('banned', function ($table) {
            $table->dropColumn('reason');
        });
    }
}
