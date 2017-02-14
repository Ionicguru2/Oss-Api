<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';

			$table->increments('id');
            $table->string('name');
            $table->string('identifier');
            $table->integer('parent_id')->unsigned()->nullable();
			$table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
		});


        Schema::create('category_images', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->enum('types', ['BUY', 'SELL', 'LISTING', 'HEADER']);
            $table->string('path');
            $table->integer('category_id')->unsigned();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });


        Schema::create('product_statuses', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('product_flags', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('identifier');
        });

        Schema::create('products', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('title');
            $table->enum('type', array('buy', 'sell'));
            $table->string('sku');
            $table->text('details');
            $table->string('certification')->nullable();
            $table->decimal('price', 10, 2);
            $table->date('available_from');
            $table->date('available_to');
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('product_statuses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('products_product_flags', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('product_flag_id')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_flag_id')->references('id')->on('product_flags')->onDelete('cascade');
        });

        Schema::create('product_media', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('path');
            $table->integer('order');
            $table->integer('product_id')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('product_meta', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('key');
            $table->String('value');
            $table->integer('product_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('product_meta');
        Schema::dropIfExists('product_media');
        Schema::dropIfExists('products_product_flags');
		Schema::dropIfExists('products');
        Schema::dropIfExists('product_flags');
        Schema::dropIfExists('product_statuses');
		Schema::dropIfExists('category_images');
		Schema::dropIfExists('categories');
	}

}
