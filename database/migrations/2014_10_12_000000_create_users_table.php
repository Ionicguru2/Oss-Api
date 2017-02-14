<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        /**
         * Create Regions table
         */
        Schema::create('regions', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
        });


        /**
         * Create Countries table
         */
        Schema::create('countries', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';


            $table->increments('id');
            $table->string('name');
            $table->integer('region_id')->unsigned();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });


        /**
         * Create companies table
         */
        Schema::create('companies', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('region_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });


        /**
         * Create Roles table
         */
        Schema::create('roles', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('identifier')->unique();
            $table->timestamps();
        });


        /**
         * Create Permission table
         */
        Schema::create('permissions', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('identifier')->unique();
            $table->string('description');
            $table->timestamps();

        });


        /**
         * Create users table
         */
		Schema::create('users', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';

            $table->increments('id');
			$table->string('firstname');
			$table->string('lastname');
			$table->string('identifier')->unique();
			$table->string('username', 50)->unique();
            $table->string('password', 60);
            $table->integer('passcode')->nullable();
			$table->bigInteger('phone')->unsigned()->nullable();
			$table->string('email')->unique();
            $table->string('sendbird')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('job')->nullable();
            $table->boolean('online')->nullable();
            $table->boolean('terms_accepted')->nullable();
            $table->integer('role_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->integer('sendbird_id')->unsigned()->nullable();
            $table->softDeletes();
			$table->rememberToken();
			$table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        /**
         * Create pivot table between Roles and Permissions
         */

        Schema::create('roles_permissions', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        /**
         * Create sessions table
         */
        Schema::create('sessions', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('rest_token');
            $table->integer('user_id')->unsigned();
            $table->integer('region_id')->unsigned()->nullable();
            $table->integer('last_activity');
            $table->timestamp('created_at');

            $table->unique(['rest_token', 'user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });

        /**
         * Create Password Resets table
         */
        Schema::create('password_resets', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->integer('pin')->unique();
            $table->timestamp('created_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });



        /**
         * Create Notification Types table
         */
        Schema::create('notification_types', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('identifier');

        });

        /**
         * Create Notifications settings table
         */
        Schema::create('notification_settings', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('notification_type_id')->unsigned();
            $table->boolean('allowed');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('notification_type_id')->references('id')->on('notification_types')->onDelete('cascade');
        });


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('notification_settings');
        Schema::dropIfExists('notification_types');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('sessions');
		Schema::dropIfExists('users');
		Schema::dropIfExists('roles_permissions');
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('roles');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('regions');
	}

}
