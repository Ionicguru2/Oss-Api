<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->call(Setup::class);
        $this->call(UserAndCompanySeeder::class);
        $this->call(NotificationSettings::class);

        Model::reguard();

	}

}
