<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestAccessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('request_accesses', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('full_name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('company');
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
        Schema::dropIfExists('request_accesses');
	}

}
