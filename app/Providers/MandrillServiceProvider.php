<?php namespace App\Providers;

use \App\Http\Helpers\Mandrill;
use Illuminate\Support\ServiceProvider;

class MandrillServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('mandrill', function ($app) {
            return new Mandrill;
        });
	}

}
