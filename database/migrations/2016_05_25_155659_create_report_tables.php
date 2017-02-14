<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('report_types', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('type');
        });

        Schema::create('reports', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('message');
            $table->integer('user_id')->unsigned();
            $table->integer('report_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_type_id')->references('id')->on('report_types')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('reports');
        Schema::dropIfExists('report_types');
	}

}
