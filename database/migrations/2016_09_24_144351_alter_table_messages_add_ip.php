<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMessagesAddIp extends Migration
{
    public function up()
    {
        Schema::table('messages', function ($table) {
            $table->string('ip', 25)->nullable();
        });
    }

    public function down()
    {
        Schema::table('messages', function ($table) {
            $table->dropColumn('ip');
        });
    }
}
