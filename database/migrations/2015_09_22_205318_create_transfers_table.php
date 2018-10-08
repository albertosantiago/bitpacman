<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
        
            $table->increments('id');
            $table->char('ip', 45);
            $table->char('address', 125);
            $table->bigInteger('amount');
		    $table->boolean('referral');
		    $table->boolean('scammer');		
            $table->timestamps();
            $table->index('ip');
            $table->index('updated_at');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transfers');
    }
}
