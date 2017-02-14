<?php namespace App\Providers;

use \App\Http\Helpers\SendBird;
use Illuminate\Support\ServiceProvider;

class SendBirdServiceProvider extends ServiceProvider {

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
        $this->app->singleton('sendbird', function ($app) {
            return new SendBird;
        });
	}

}
