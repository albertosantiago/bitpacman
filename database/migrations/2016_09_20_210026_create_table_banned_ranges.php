<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBannedRanges extends Migration {

	public function up()
	{
		Schema::table('banned', function ($table) {
			$table->dropColumn('network');
		});

		Schema::create('banned_ranges', function (Blueprint $table) {
            $table->increments('id');
			$table->string('asn_name');
			$table->integer('asn_id');
			$table->string('cidr');
			$table->bigInteger('start');
			$table->bigInteger('end');
			$table->dateTime('freedom_date');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('banned_ranges');
		Schema::table('banned', function ($table) {
            $table->string('network');
        });
	}
}
