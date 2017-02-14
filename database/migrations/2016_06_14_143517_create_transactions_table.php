<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('offers', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('accepted')->nullable();
            $table->boolean('confirmed')->nullable();
            $table->boolean('enable_owner');
            $table->boolean('enable_user');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('transaction_stages', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('identifier');
        });


        Schema::create('transaction_flags', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('flag');
        });

		Schema::create('transactions', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';

			$table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('offer_id')->unsigned();
            $table->boolean('enable');
            $table->string('sendbird_name')->nullable();
            $table->string('sendbird_url')->nullable();
            $table->boolean('validation')->nullable();
            $table->integer('transaction_stage_id')->unsigned();
            $table->integer('transaction_flag_id')->unsigned()->nullable();
            $table->softDeletes();
			$table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('transaction_stage_id')->references('id')->on('transaction_stages')->onDelete('cascade');
            $table->foreign('transaction_flag_id')->references('id')->on('transaction_flags')->onDelete('cascade');
		});

        Schema::create('transactions_users', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('validation_request')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'transaction_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });


        Schema::create('rating_required', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->integer('user_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->timestamp('created_at');

            $table->unique(['user_id', 'transaction_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });

        Schema::create('transaction_ratings', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->integer('rating')->unsigned();
            $table->timestamp('created_at');

            $table->unique(['user_id', 'transaction_id']);
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('messages', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->integer('message_id')->unsigned();
            $table->string('nickname');
            $table->string('data');
            $table->string('message');
            $table->integer('id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->timestamp('timestamp');

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('messages');
        Schema::dropIfExists('transaction_ratings');
        Schema::dropIfExists('rating_required');
        Schema::dropIfExists('transactions_users');
		Schema::dropIfExists('transactions');
        Schema::dropIfExists('transaction_flags');
		Schema::dropIfExists('transaction_stages');
        Schema::dropIfExists('offers');
	}

}
