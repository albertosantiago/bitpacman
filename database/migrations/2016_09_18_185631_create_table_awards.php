<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAwards extends Migration {


   public function up()
   {
	   Schema::create('extra_awards', function (Blueprint $table) {
		   $table->increments('id');
		   $table->char('ip', 45);
		   $table->char('address', 125);
		   $table->bigInteger('amount');
		   $table->timestamps();
	   });
   }

   /**
	* Reverse the migrations.
	*
	* @return void
	*/
   public function down()
   {
	   Schema::drop('extra_awards');
   }

}
